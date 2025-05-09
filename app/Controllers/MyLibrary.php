<?php

namespace App\Controllers;

use App\Models\MultipleChoiceQuestion;
use App\Models\TextInputQuestion;

class MyLibrary extends BaseController
{
    public function index(): void
    {
        $this->checkAuth();

        global $db;

        if (isset($_GET['quiz'])) { // nếu có query string quiz thì sẽ render trang chỉnh sửa quiz
            $quizDetails = $this->getQuizBySlug($_GET['quiz']);

            if (is_null($quizDetails)) {
                header('Location: /404');
                exit;
            }

            $this->render('edit-quiz', [
                'title' => $quizDetails['name'],
                'quiz' => $quizDetails,
                'heading' => $quizDetails['name'],
            ]);
        } else { // không có thì render trang quản lý quiz
            $quizzes = $db->getMany('quizzes', "`user_id` = {$_SESSION['user']['id']} ORDER BY `created_at` DESC"); // sắp xếp theo tạo mới nhất

            $this->render('my-library', [
                'title' => 'Thư viện của tôi',
                'quizzes' => $quizzes,
                'heading' => 'Thư viện của tôi (' . number_format(count($quizzes)) . ' quiz)',
            ]);
        }
    }

    protected function getQuizBySlug($slug): ?array
    {
        global $db;

        $slug = $db->conn->real_escape_string($slug);

        // Lấy quiz, question và đáp án
        // - questions: lấy tất cả câu hỏi thuộc quiz
        // - options: lấy các đáp án cho câu hỏi có type = multiple_choice
        // - text_answers: lấy đáp án cho câu hỏi có type = text_input
        $sql = "
        SELECT 
            q.*, 
            ques.id as question_id, 
            ques.content as question_content, 
            ques.type as question_type,
            ques.points as question_points,
            ques.quiz_id as question_quiz_id,
            opt.id as option_id,
            opt.content as option_content,
            opt.is_correct as option_is_correct,
            ta.id as text_answer_id,
            ta.content as text_answer_content
        FROM 
            quizzes q
        LEFT JOIN 
            questions ques ON q.id = ques.quiz_id
        LEFT JOIN 
            options opt ON ques.id = opt.question_id AND ques.type = 'multiple_choice'
        LEFT JOIN 
            text_answers ta ON ques.id = ta.question_id AND ques.type = 'text_input'
        WHERE 
            q.slug = '$slug' AND q.user_id = {$_SESSION['user']['id']}
    ";

        $result = $db->raw($sql);

        if (!$result || $result->num_rows === 0) {
            return null;
        }

        $quiz = null;
        $questions = [];

        // xử lý result thành dạng quiz[questions[]]
        while ($row = $result->fetch_assoc()) {
            if ($quiz === null) {
                $quiz = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'image' => $row['image'],
                    'slug' => $row['slug'],
                    'play' => $row['play'],
                    'duration_minutes' => $row['duration_minutes'],
                    'is_public' => $row['is_public'],
                    'user_id' => $row['user_id'],
                    'created_at' => $row['created_at']
                ];
            }

            // thêm question vào mảng questions nếu chưa tồn tại
            $questionId = $row['question_id'];
            if ($questionId && !isset($questions[$questionId])) {
                $questions[$questionId] = [
                    'id' => $questionId,
                    'content' => $row['question_content'],
                    'type' => $row['question_type'],
                    'points' => $row['question_points'],
                    'answers' => []
                ];
            }

            // thêm đáp án cho question tương ứng dựa vào type
            if ($questionId) {
                if ($row['question_type'] == 'multiple_choice' && $row['option_id']) {
                    $questions[$questionId]['answers'][] = [
                        'id' => $row['option_id'],
                        'content' => $row['option_content'],
                        'is_correct' => $row['option_is_correct']
                    ];
                } else if ($row['question_type'] == 'text_input' && $row['text_answer_id']) {
                    $questions[$questionId]['answers'][] = [
                        'id' => $row['text_answer_id'],
                        'content' => $row['text_answer_content']
                    ];
                }
            }
        }

        // chuyển từ key-value sang mảng tuần tự rồi reverse questions[] để hiện question mới ở cuối
        $quiz['questions'] = array_reverse(array_values($questions));

        return $quiz;
    }

    public function addNewQuestion()
    {
        // lấy input từ request
        $input = json_decode(file_get_contents('php://input'), true);

        $content = $input['content'] ?? '';
        $type = $input['questionType'] ?? '';
        $quizId = $input['quizId'] ?? '';
        $points = $input['points'] ?? 1;
        $answers = $input['options'] ?? $input['answer'] ?? [];

        if (!in_array($type, ['multipleChoice', 'textInput'])) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Loại câu hỏi không hợp lệ',
            ]);
        }

        $question = $type === 'multipleChoice'
            ? new MultipleChoiceQuestion()
            : new TextInputQuestion();

        $question->setContent($content)
            ->setQuizId($quizId)
            ->setPoints($points)
            ->save();

        $question->saveAnswers($answers);

        return $this->responseJson([
            'ok' => true,
            'msg' => 'Thêm câu hỏi thành công',
        ]);
    }

    public function deleteQuestionById()
    {
        global $db;
        $input = json_decode(file_get_contents('php://input'), true);

        $questionId = $input['questionId'] ?? '';
        $quizId = $input['quizId'] ?? '';

        if (empty($questionId)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'ID câu hỏi không hợp lệ',
            ]);
        }

        $question = $db->get('questions', "`id` = '$questionId' AND `quiz_id` = '$quizId'");
        if (!$question) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Câu hỏi không tồn tại',
            ]);
        }

        $quiz = $db->get('quizzes', "`id` = '{$quizId}' AND `user_id` = {$_SESSION['user']['id']}");
        if (!$quiz) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Không thể xóa câu hỏi này',
            ]);
        }

        $db->delete('questions', "`id` = '$questionId' AND `quiz_id` = '$quizId'");

        return $this->responseJson([
            'ok' => true,
            'msg' => 'Xóa câu hỏi thành công',
        ]);
    }
}
