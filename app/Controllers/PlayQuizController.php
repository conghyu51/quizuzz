<?php

namespace App\Controllers;

class PlayQuizController extends BaseController
{
    public function index(): void
    {
        $slug = $_GET['quiz'] ?? null;

        if (!$slug) {
            header('Location: /404');
            exit;
        }

        global $db;

        $slug = $db->conn->real_escape_string($slug);

        $result = $db->raw("SELECT * FROM quizzes WHERE slug = '$slug' AND is_public = 1");

        if (!$result || $result->num_rows === 0) {
            header('Location: /404');
            exit;
        }

        $quiz = $result->fetch_assoc();
        $countQuestions = $db->raw("SELECT COUNT(*) as count FROM questions WHERE quiz_id = {$quiz['id']}");

        $quiz['username'] = $db->raw("SELECT username FROM users WHERE id = {$quiz['user_id']}")->fetch_assoc()['username'];
        $quiz['questions'] = $countQuestions->fetch_assoc()['count'];

        $this->render('play/index', [
            'title' => $quiz['name'],
            'customAction' => BASE . '/views/components/back-button.php',
            'quiz' => $quiz,
        ]);
    }

    public function start(): void
    {
        global $db;

        $quizId = $_POST['quizId'] ?? null;

        if (!$quizId) {
            header('Location: /');
            exit;
        }

        $quiz = $db->get('quizzes', "id = '$quizId'");
        if (!$quiz) {
            header('Location: /');
            exit;
        }

        $db->create('quiz_attempts', [
            'quiz_id' => $quizId,
            'user_id' => $_SESSION['user']['id'],
            'started_at' => date('Y-m-d H:i:s'),
            'score' => 0,
        ]);

        $attemptId = $db->raw("SELECT LAST_INSERT_ID()")->fetch_row()[0];

        $_SESSION['quiz_attempt'] = [
            'id' => $attemptId,
            'quiz_id' => $quizId,
            'current_question' => 0,
            'started_at' => time(),
        ];

        $db->raw("UPDATE quizzes SET play = play + 1 WHERE id = $quizId");

        header('Location: /choi/cau-hoi');
        exit;
    }

    public function question(): void
    {
        if (!isset($_SESSION['quiz_attempt'])) {
            header('Location: /');
            exit;
        }

        $attempt = $_SESSION['quiz_attempt'];
        $currentQuestionIndex = $attempt['current_question'];

        $quiz = $this->getQuizWithQuestions($attempt['quiz_id']);

        // Kiểm tra nếu đã làm xong hết câu hỏi
        if ($currentQuestionIndex >= count($quiz['questions'])) {
            header('Location: /choi/ket-qua');
            exit;
        }

        $question = $quiz['questions'][$currentQuestionIndex];

        $this->render('play/question', [
            'title' => $quiz['name'] . ' - Câu hỏi ' . ($currentQuestionIndex + 1),
            'quiz' => $quiz,
            'customAction' => BASE . '/views/components/cancel-quiz-play-button.php',
            'question' => $question,
            'questionIndex' => $currentQuestionIndex,
            'totalQuestions' => count($quiz['questions']),
            'timeLeft' => $this->calculateTimeLeft($quiz, $attempt)
        ]);
    }

    protected function getQuizWithQuestions($quizId): ?array
    {
        global $db;

        $quizId = $db->conn->real_escape_string($quizId);

        $quiz = $db->get('quizzes', "id = '$quizId'");
        if (!$quiz) {
            return null;
        }

        // Lấy các câu hỏi của quiz
        $questions = [];
        $questionsResult = $db->getMany('questions', "quiz_id = '$quizId'");

        foreach ($questionsResult as $question) {
            $questionData = [
                'id' => $question['id'],
                'content' => $question['content'],
                'type' => $question['type'],
                'points' => $question['points'],
                'answers' => []
            ];

            // lấy các đáp án nếu type question = multiple_choice
            if ($question['type'] == 'multiple_choice') {
                $options = $db->getMany('options', "question_id = '{$question['id']}'");
                $questionData['answers'] = $options;
            }

            $questions[] = $questionData;
        }

        $quiz['questions'] = $questions;

        return $quiz;
    }

    protected function calculateTimeLeft($quiz, $attempt): int
    {
        $durationSeconds = $quiz['duration_minutes'] * 60;
        $elapsedSeconds = time() - $attempt['started_at'];
        $timeLeft = max(0, $durationSeconds - $elapsedSeconds);

        return $timeLeft;
    }

    public function submitAnswer(): void
    {
        // Kiểm tra phiên làm bài
        if (!isset($_SESSION['quiz_attempt'])) {
            $this->responseJson([
                'ok' => false,
                'msg' => 'Phiên làm bài không tồn tại'
            ]);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $questionId = $input['questionId'] ?? null;
        $answer = $input['answer'] ?? null;

        if (!$questionId) {
            $this->responseJson([
                'ok' => false,
                'msg' => 'Dữ liệu không hợp lệ'
            ]);
            return;
        }

        global $db;

        $question = $db->get('questions', "id = '$questionId'");
        if (!$question) {
            $this->responseJson([
                'ok' => false,
                'msg' => 'Câu hỏi không tồn tại'
            ]);
            return;
        }

        $attempt = $_SESSION['quiz_attempt'];
        $isCorrect = false;
        $correctAnswer = null;

        // Kiểm tra đáp án
        if ($question['type'] == 'multiple_choice') {
            $option = $db->get('options', "id = '$answer' AND question_id = '$questionId'");
            $isCorrect = $option && $option['is_correct'] == 1;

            // Lấy đáp án đúng để hiển thị
            $correctOption = $db->get('options', "question_id = '$questionId' AND is_correct = 1");
            $correctAnswer = $correctOption['content'] ?? null;
        } else if ($question['type'] == 'text_input') {
            // Lấy đáp án đúng cho câu hỏi text_input
            $textAnswers = $db->getMany('text_answers', "question_id = '$questionId'");

            foreach ($textAnswers as $textAnswer) {
                $userAnswer = trim(strtolower($answer));
                $correctText = trim(strtolower($textAnswer['content']));

                if ($userAnswer == $correctText) {
                    $isCorrect = true;
                    break;
                }
            }

            $correctAnswer = !empty($textAnswers) ? $textAnswers[0]['content'] : null;
        }

        // Lưu câu trả lời
        $this->saveUserResponse($attempt['id'], $questionId, $answer, $isCorrect);

        $_SESSION['quiz_attempt']['current_question']++;

        $this->responseJson([
            'ok' => true,
            'isCorrect' => $isCorrect,
            'correctAnswer' => $correctAnswer,
            'points' => $isCorrect ? $question['points'] : 0
        ]);
    }

    protected function saveUserResponse($attemptId, $questionId, $answer, $isCorrect): void
    {
        global $db;

        $question = $db->get('questions', "id = '$questionId'");

        $data = [
            'quiz_attempt_id' => $attemptId,
            'question_id' => $questionId,
            'is_correct' => $isCorrect ? 1 : 0,
            'points_earned' => $isCorrect ? $question['points'] : 0,
        ];

        if ($question['type'] == 'multiple_choice') {
            $data['option_id'] = $answer;
        } else if ($question['type'] == 'text_input') {
            $data['text_response'] = $answer;
        }

        $db->create('answers', $data);

        if ($isCorrect) {
            $db->raw("UPDATE quiz_attempts SET score = score + {$question['points']} WHERE id = $attemptId");
        }
    }

    public function result(): void
    {
        if (!isset($_SESSION['quiz_attempt'])) {
            header('Location: /');
            exit;
        }

        $attempt = $_SESSION['quiz_attempt'];
        $attemptId = $attempt['id'];

        $this->finishQuizAttempt($attemptId);
        $results = $this->getQuizResults($attemptId);
        unset($_SESSION['quiz_attempt']);

        $this->render('play/result', [
            'title' => 'Kết quả',
            'results' => $results,
            'customAction' => BASE . '/views/components/back-home-button.php',
            'heading' => 'Kết quả #' . $attemptId,
        ]);
    }

    protected function getQuizResults($attemptId): array
    {
        global $db;

        $attempt = $db->get('quiz_attempts', "id = '$attemptId'");
        $quizId = $attempt['quiz_id'];

        $quiz = $db->get('quizzes', "id = '$quizId'");

        // Lấy tất cả câu trả lời
        $responses = $db->getMany('answers', "quiz_attempt_id = '$attemptId'");

        // Đếm số câu trả lời đúng
        $correctCount = 0;
        foreach ($responses as $response) {
            if ($response['is_correct'] == 1) {
                $correctCount++;
            }
        }

        return [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'total_questions' => count($responses),
            'correct_count' => $correctCount,
            'score' => $attempt['score']
        ];
    }

    protected function finishQuizAttempt($attemptId): void
    {
        global $db;

        $db->update('quiz_attempts', [
            'completed_at' => date('Y-m-d H:i:s'),
        ], "id = '$attemptId'");
    }
}
