<div class="modal modal-blur fade" id="modal-create-new-quiz" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tạo quiz mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="createNewQuizForm">
                    <div class="mb-3">
                        <label class="form-label required" for="quizName">Tên quiz</label>
                        <input type="text" class="form-control" name="quizName" id="quizName" required placeholder="???" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="image">Link ảnh bìa</label>
                        <input type="text" class="form-control" name="image" id="image" required />
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
                            <input type="number" class="form-control" name="durationMinutes" id="durationMinutes" required value="30" autocomplete="off" min="0" max="65535" />
                            <span class="input-group-text"> phút </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="isPublic">Công khai?</label>
                        <select class="form-select" name="isPublic" id="isPublic">
                            <option value="true">Có</option>
                            <option value="false" selected>Không</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
                    Huỷ
                </a>
                <button class="btn btn-primary btn-5 ms-auto" type="submit" id="createNewQuizButton" form="createNewQuizForm">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-2">
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Tạo
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createNewQuizForm = document.getElementById('createNewQuizForm');
        const createNewQuizButton = document.getElementById('createNewQuizButton');

        createNewQuizForm.addEventListener('submit', function(e) {
            e.preventDefault();

            createNewQuizButton.disabled = true;
            createNewQuizButton.textContent = 'Đang tạo...';

            const formData = new FormData(createNewQuizForm);

            fetch('/tao-quiz-moi', {
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
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                });

            createNewQuizButton.disabled = false;
            createNewQuizButton.textContent = 'Tạo';
        });
    });
</script>
