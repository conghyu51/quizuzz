<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="col-5">
                        <div class="progress progress-1">
                            <div class="progress-bar" role="progressbar" style="width: <?= ($questionIndex / $totalQuestions) * 100 ?>%"
                                aria-valuenow="<?= ($questionIndex / $totalQuestions) * 100 ?>" aria-valuemin="0" aria-valuemax="100">
                                <span class="visually-hidden"><?= $questionIndex + 1 ?>/<?= $totalQuestions ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <div id="quiz-timer" data-time-left="<?= $timeLeft ?>">
                            <div class="badge bg-warning text-dark p-2">
                                Thời gian còn:
                                <span id="timer-display"><?= floor($timeLeft / 60) ?>:<?= sprintf('%02d', $timeLeft % 60) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        Câu hỏi <?= number_format($questionIndex + 1) ?>
                        <span class="badge bg-blue text-blue-fg ms-1">
                            <?= number_format($question['points']) ?> điểm
                        </span>: <?= e($question['content']) ?>
                    </h3>
                </div>
                <div class="card-body pt-2 pb-4">
                    <div id="answer-container" data-question-id="<?= $question['id'] ?>" data-question-type="<?= $question['type'] ?>">
                        <?php if ($question['type'] == 'multiple_choice'): ?>
                            <div class="options-container">
                                <?php foreach ($question['answers'] as $option): ?>
                                    <div class="option-item mt-3">
                                        <button class="btn btn-outline-secondary w-100 py-3 option-btn" data-option-id="<?= $option['id'] ?>">
                                            <?= e($option['content']) ?>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif ($question['type'] == 'text_input'): ?>
                            <div class="text-answer-container">
                                <div class="mb-3">
                                    <input type="text" id="text-answer" class="form-control form-control-lg" placeholder="Nhập câu trả lời của bạn">
                                </div>
                                <button id="submit-text" class="btn btn-primary">Trả lời</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timerElement = document.getElementById('quiz-timer');
        const timerDisplay = document.getElementById('timer-display');
        let timeLeft = parseInt(timerElement.dataset.timeLeft);

        const timer = setInterval(function() {
            timeLeft--;

            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = '/choi/ket-qua';
            }

            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

            if (timeLeft <= 30) {
                timerDisplay.classList.add('text-danger');
            }
        }, 1000);

        const optionButtons = document.querySelectorAll('.option-btn');
        optionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const questionId = document.getElementById('answer-container').dataset.questionId;
                const optionId = this.dataset.optionId;

                submitAnswer(questionId, optionId);
            });
        });

        const submitTextButton = document.getElementById('submit-text');
        if (submitTextButton) {
            submitTextButton.addEventListener('click', function() {
                const questionId = document.getElementById('answer-container').dataset.questionId;
                const answer = document.getElementById('text-answer').value;

                if (!answer.trim()) {
                    alert('Vui lòng nhập câu trả lời');
                    return;
                }

                submitAnswer(questionId, answer);
            });
        }

        function submitAnswer(questionId, answer) {
            const data = {
                questionId: questionId,
                answer: answer
            };

            fetch('/choi/gui-dap-an', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        showFeedback(data);
                    } else {
                        alert(data.msg || 'Có lỗi xảy ra');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi gửi câu trả lời');
                });
        }

        function showFeedback(data) {
            if (data.isCorrect) {
                swal({
                    title: 'Chính xác',
                    text: 'Cộng ' + data.points + ' điểm',
                    icon: 'success',
                    button: 'Câu tiếp theo',
                });
            } else {
                swal({
                    title: 'Sai rồi',
                    text: 'Đáp án đúng là: ' + data.correctAnswer,
                    icon: 'error',
                    button: 'Câu tiếp theo',
                });
            }

            setTimeout(function() {
                window.location.href = '/choi/cau-hoi';
            }, 1000);
        }
    });
</script>
