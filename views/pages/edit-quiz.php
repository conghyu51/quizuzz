<div class="row row-cards">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông tin cơ bản</h3>
                <div class="card-actions">
                    <button type="submit" form="quizDetailsForm" class="btn btn-primary" id="saveQuizButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M14 4l0 4l-6 0l0 -4" />
                        </svg>
                        Lưu
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form autocomplete="off" id="quizDetailsForm">
                    <div class="mb-3">
                        <label class="form-label required" for="quizName">Tên quiz</label>
                        <input type="text" class="form-control" name="quizName" id="quizName" required value="<?= e($quiz['name']) ?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="image">Link ảnh bìa</label>
                        <input type="text" class="form-control" name="image" id="image" required value="<?= e($quiz['image']) ?>" />
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label required" for="durationMinutes">Giới hạn thời gian</label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Thời gian tối đa để hoàn thành quiz">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M12 9h.01" />
                                <path d="M11 12h1v4h1" />
                            </svg>
                        </div>
                        <div class="input-group">
                            <input type="number" class="form-control" name="durationMinutes" id="durationMinutes" required value="<?= e($quiz['duration_minutes']) ?>" autocomplete="off" min="0" max="65535" />
                            <span class="input-group-text"> phút </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="isPublic">Công khai?</label>
                        <select class="form-select" name="isPublic" id="isPublic">
                            <option value="1" <?php if ((bool) $quiz['is_public']) echo 'selected'; ?>>Có</option>
                            <option value="0" <?php if (!((bool) $quiz['is_public'])) echo 'selected'; ?>>Không</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-5">Lượt chơi:</dt>
                    <dd class="col-7"><?= number_format(e($quiz['play'])) ?></dd>
                    <dt class="col-5">Tạo lúc:</dt>
                    <dd class="col-7"><?= e((new DateTimeImmutable($quiz['created_at']))->format('H:i:s d/m/Y')) ?></dd>
                    <dt class="col-5">Số câu hỏi:</dt>
                    <dd class="col-7"><?= number_format(count($quiz['questions'])) ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header border-bottom-0">
                <h3 class="card-title" id="quizToolbar">
                    Câu hỏi
                </h3>
                <div class="card-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-new-question">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-text-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19 10h-14" />
                            <path d="M5 6h14" />
                            <path d="M14 14h-9" />
                            <path d="M5 18h6" />
                            <path d="M18 15v6" />
                            <path d="M15 18h6" />
                        </svg>
                        Thêm câu hỏi
                    </button>
                    <button class="btn btn-danger" onclick="deleteQuiz()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7l16 0" />
                            <path d="M10 11l0 6" />
                            <path d="M14 11l0 6" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                        Xoá quiz
                    </button>
                </div>
            </div>
        </div>
        <?php foreach ($quiz['questions'] as $index => $question): ?>
            <?php if ($question['type'] == 'multiple_choice'): ?>
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            Câu hỏi <?= $index + 1 ?>: <?= e($question['content']) ?>
                            <span class="badge bg-blue text-blue-fg">
                                <?= number_format($question['points']) ?> điểm
                            </span>
                        </h3>
                        <div class="card-actions">
                            <button class="btn btn-danger btn-icon" type="button" onclick="deleteQuestion(<?= e($question['id']) ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <?php
                        $answersCount = count($question['answers']);
                        for ($i = 0; $i < $answersCount; $i += 2):
                        ?>
                            <div class="row mt-2">
                                <div class="d-flex align-items-center col">
                                    <span class="avatar avatar-sm <?= $question['answers'][$i]['is_correct'] ? 'bg-green-lt' : 'bg-red-lt' ?>">
                                        <?= chr(65 + $i) ?>
                                    </span>
                                    <div class="ms-2">
                                        <?= e($question['answers'][$i]['content']) ?>
                                    </div>
                                </div>
                                <?php if ($i + 1 < $answersCount): ?>
                                    <div class="d-flex align-items-center col">
                                        <span class="avatar avatar-sm <?= $question['answers'][$i + 1]['is_correct'] ? 'bg-green-lt' : 'bg-red-lt' ?>">
                                            <?= chr(65 + $i + 1) ?>
                                        </span>
                                        <div class="ms-2">
                                            <?= e($question['answers'][$i + 1]['content']) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            Câu hỏi <?= $index + 1 ?>: <?= e($question['content']) ?>
                            <span class="badge bg-blue text-blue-fg">
                                <?= number_format($question['points']) ?> điểm
                            </span>
                        </h3>
                        <div class="card-actions">
                            <button class="btn btn-danger btn-icon" type="button" onclick="deleteQuestion(<?= e($question['id']) ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Đáp án</div>
                                <div class="datagrid-content">
                                    <?= e($question['answers'][0]['content']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</div>
<script>
    function deleteQuiz() {
        swal({
            title: 'Chắc chắn muốn xoá quiz này?',
            text: 'Bạn sẽ không thể hoàn tác lại hành động này!',
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: "Huỷ",
                confirm: {
                    text: "Xoá",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: false
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                fetch('/xoa-quiz?quizId=<?= e($quiz['id']) ?>', {
                        method: 'DELETE',
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (!response.ok) {
                            swal({
                                title: 'Thất bại',
                                text: response.msg,
                                icon: 'error',
                                button: "OK",
                            });
                        } else {
                            swal({
                                title: 'Thành công',
                                text: response.msg,
                                icon: 'success',
                                button: "OK",
                            });

                            setTimeout(() => {
                                window.location.href = '/thu-vien-cua-toi';
                            }, 1000);
                        }
                    });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const quizDetailsForm = document.getElementById('quizDetailsForm');
        const saveQuizButton = document.getElementById('saveQuizButton');

        quizDetailsForm.addEventListener('submit', function(e) {
            e.preventDefault();

            saveQuizButton.disabled = true;
            saveQuizButton.textContent = 'Đang lưu...';

            const formData = new FormData(quizDetailsForm);

            fetch('/luu-quiz?quizId=<?= e($quiz['id']) ?>', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(response => {
                    if (!response.ok) {
                        swal({
                            title: 'Thất bại',
                            text: response.msg,
                            icon: 'error',
                            button: "OK",
                        });
                    } else {
                        swal({
                            title: 'Thành công',
                            text: response.msg,
                            icon: 'success',
                            button: "OK",
                        });

                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                });

            saveQuizButton.disabled = false;
            saveQuizButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M14 4l0 4l-6 0l0 -4" />
                </svg>
                Lưu`;
        });
    });

    function deleteQuestion(id) {
        fetch('/xoa-cau-hoi', {
                method: 'DELETE',
                body: JSON.stringify({
                    questionId: id,
                    quizId: <?= e($quiz['id']) ?>
                }),
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(response => {
                if (!response.ok) {
                    swal({
                        title: 'Thất bại',
                        text: response.msg,
                        icon: 'error',
                        button: "OK",
                    });
                } else {
                    location.reload();
                }
            });
    }
</script>
