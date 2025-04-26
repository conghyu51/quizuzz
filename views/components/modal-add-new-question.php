<div class="modal modal-blur fade" id="modal-add-new-question" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm câu hỏi mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="addNewQuestionForm">
                    <div class="mb-3">
                        <label class="form-label required" for="questionContent">Câu hỏi</label>
                        <input type="text" class="form-control" name="questionContent" id="questionContent" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="questionPoint">Điểm (Tối thiểu 1 điểm)</label>
                        <input type="number" class="form-control" name="questionPoint" id="questionPoint" required min="1" value="1" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Loại câu hỏi</label>
                        <div class="form-selectgroup">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="questionType" value="multipleChoice" class="form-selectgroup-input" checked="">
                                <span class="form-selectgroup-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-category-plus me-1">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4h6v6h-6zm10 0h6v6h-6zm-10 10h6v6h-6zm10 3h6m-3 -3v6" />
                                    </svg>
                                    Chọn đáp án
                                </span>
                            </label>
                            <label class="form-selectgroup-item">
                                <input type="radio" name="questionType" value="textInput" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-forms me-1">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3a3 3 0 0 0 -3 3v12a3 3 0 0 0 3 3" />
                                        <path d="M6 3a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3" />
                                        <path d="M13 7h7a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-7" />
                                        <path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1" />
                                        <path d="M17 12h.01" />
                                        <path d="M13 12h.01" />
                                    </svg>
                                    Nhập đáp án
                                </span>
                            </label>
                        </div>
                    </div>
                    <div id="multipleChoiceAnswersContainer">
                        <label class="form-label required">Các đáp án</label>
                        <div id="optionsContainer">
                            <div class="input-group optionContainer">
                                <span class="input-group-text">A</span>
                                <input type="text" class="form-control" name="optionAnswers[]" required />
                            </div>
                            <div class="input-group mt-2 optionContainer">
                                <span class="input-group-text">B</span>
                                <input type="text" class="form-control" name="optionAnswers[]" required />
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-primary" id="addOptionButton">
                                Thêm đáp án
                            </button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Đáp án đúng</label>
                            <select class="form-select" name="correctAnswer" id="correctAnswer" required>
                                <option value="" disabled selected>Chọn đáp án đúng</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3" id="textInputAnswerContainer" style="display: none;">
                        <label class="form-label required">Đáp án</label>
                        <input type="text" class="form-control" name="textAnswer" id="textAnswer" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal">
                    Huỷ
                </a>
                <button class="btn btn-primary btn-5 ms-auto" type="submit" id="addNewQuestionButton" form="addNewQuestionForm">
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
                    Thêm
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questionType = document.querySelectorAll('input[name="questionType"]');
        const textInputAnswerContainer = document.getElementById('textInputAnswerContainer');
        const multipleChoiceAnswersContainer = document.getElementById('multipleChoiceAnswersContainer');
        const correctAnswerInput = document.getElementById('correctAnswer');

        questionType.forEach(type => {
            type.addEventListener('change', function() {
                if (this.value === 'textInput') {
                    multipleChoiceAnswersContainer.style.display = 'none';
                    textInputAnswerContainer.style.display = 'block';

                    const optionInputs = document.querySelectorAll('input[name="optionAnswers[]"]');
                    optionInputs.forEach(input => {
                        input.removeAttribute('required');
                    });

                    textInputAnswerContainer.querySelector('input[name="textAnswer"]').setAttribute('required', 'required');
                    correctAnswerInput.removeAttribute('required');
                } else if (this.value === 'multipleChoice') {
                    multipleChoiceAnswersContainer.style.display = 'block';
                    textInputAnswerContainer.style.display = 'none';

                    const optionInputs = document.querySelectorAll('input[name="optionAnswers[]"]');
                    optionInputs.forEach(input => {
                        input.setAttribute('required', 'required');
                    });

                    textInputAnswerContainer.querySelector('input[name="textAnswer"]').removeAttribute('required');
                    correctAnswerInput.setAttribute('required', 'required');
                } else {
                    multipleChoiceAnswersContainer.style.display = 'none';
                    textInputAnswerContainer.style.display = 'none';
                }
            });
        });

        const addOptionButton = document.getElementById('addOptionButton');
        const optionsContainer = document.getElementById('optionsContainer');

        let optionCount = 1;

        addOptionButton.addEventListener('click', function() {
            const optionDiv = document.createElement('div');
            optionDiv.className = 'row mt-2 optionContainer';
            const optionValue = String.fromCharCode(66 + optionCount);
            optionDiv.innerHTML = `
                <div class="col" data-id="${optionCount}">
                    <div class="input-group">
                        <span class="input-group-text">${optionValue}</span>
                        <input type="text" class="form-control" name="optionAnswers[]" required />
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-2 btn-icon removeOption" type="button" data-id="option-${optionCount}"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    </button>
                </div>
            `;

            optionsContainer.appendChild(optionDiv);
            optionCount++;

            const newOption = document.createElement('option');
            newOption.value = optionValue;
            newOption.textContent = optionValue;
            document.getElementById('correctAnswer').appendChild(newOption);

            optionDiv.querySelector('.removeOption').addEventListener('click', function() {
                const optionId = this.getAttribute('data-id');
                const optionElement = document.querySelector(`.optionContainer:has([data-id="${optionId}"])`);

                optionElement.remove();

                const optionValue = optionElement.querySelector('.input-group-text').textContent;

                const correctAnswerSelect = document.getElementById('correctAnswer');
                correctAnswerSelect.removeChild(correctAnswerSelect.querySelector(`option[value="${optionValue}"]`));

                optionCount--;
            });
        });

        const addNewQuestionForm = document.getElementById('addNewQuestionForm');
        const addNewQuestionButton = document.getElementById('addNewQuestionButton');

        addNewQuestionForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                content: document.getElementById('questionContent').value,
                questionType: document.querySelector('input[name="questionType"]:checked').value,
                quizId: <?= $quiz['id'] ?>,
                points: document.getElementById('questionPoint').value,
            };

            addNewQuestionButton.disabled = true;
            addNewQuestionButton.textContent = 'Đang thêm...';

            const questionType = document.querySelector('input[name="questionType"]:checked').value;

            if (questionType === 'multipleChoice') {
                const options = [];
                const optionElements = document.querySelectorAll('.optionContainer');

                optionElements.forEach(el => {
                    const optionAnswer = el.querySelector('input[name="optionAnswers[]"]').value;
                    const optionValue = el.querySelector('.input-group-text').textContent;
                    const correctAnswer = document.getElementById('correctAnswer').value;

                    options.push({
                        content: optionAnswer,
                        is_correct: correctAnswer === optionValue,
                    });
                });

                formData.options = options;
            } else if (questionType === 'textInput') {
                formData.answer = {
                    content: document.getElementById('textAnswer').value,
                };
            }

            fetch('/them-cau-hoi-moi', {
                    method: 'POST',
                    body: JSON.stringify(formData),
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
                            location.reload();
                        }, 1000);
                    }
                });

            addNewQuestionButton.disabled = false;
            addNewQuestionButton.textContent = 'Thêm';
        });
    });
</script>
