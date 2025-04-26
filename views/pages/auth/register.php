<form class="card card-md" autocomplete="off" id="registerForm">
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Đăng ký tài khoản</h2>
        <div class="mb-3">
            <label class="form-label" for="username">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" autofocus required minlength="6" maxlength="20" placeholder="quizuzz">
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Mật khẩu</label>
            <div class="input-group input-group-flat">
                <input type="password" class="form-control" autocomplete="off" id="password" name="password" required minlength="6" maxlength="64" placeholder="••••••••">
                <span class="input-group-text">
                    <a href="#!" class="link-secondary" aria-label="Hiện mật khẩu" id="showPassword">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                        </svg>
                    </a>
                </span>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="passwordConfirmation">Nhập lại mật khẩu</label>
            <div class="input-group input-group-flat">
                <input type="password" class="form-control" autocomplete="off" id="passwordConfirmation" name="passwordConfirmation" required placeholder="••••••••">
                <span class="input-group-text">
                    <a href="#!" class="link-secondary" aria-label="Hiện mật khẩu" id="showPassword2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                        </svg>
                    </a>
                </span>
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100" id="registerButton">
                Đăng ký
            </button>
        </div>
    </div>
</form>
<div class="text-center text-secondary mt-3">
    Đã có tài khoản? <a href="/dang-nhap" tabindex="-1">Đăng nhập</a>
</div>

<script>
    showPasswordButton = document.getElementById('showPassword');
    showPasswordButton2 = document.getElementById('showPassword2');

    function handleShowPassword() {
        const passwordField = document.getElementById('password');
        const passwordConfirmationField = document.getElementById('passwordConfirmation');
        const type = passwordField.type === 'password' ? 'text' : 'password';

        passwordField.type = type;
        passwordConfirmationField.type = type;

        showPasswordButton.innerHTML = type === 'text' ?
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>' :
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>';

        showPasswordButton2.innerHTML = type === 'text' ?
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>' :
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>';

        if (type === 'text') {
            passwordField.placeholder = 'dcsvn_quangvinh_muonnam';
            passwordConfirmationField.placeholder = 'dcsvn_quangvinh_muonnam';
        } else {
            passwordField.placeholder = '••••••••';
            passwordConfirmationField.placeholder = '••••••••';
        }
    }

    showPasswordButton.addEventListener('click', handleShowPassword);
    showPasswordButton2.addEventListener('click', handleShowPassword);

    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        const registerButton = document.getElementById('registerButton');

        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();

            registerButton.disabled = true;
            registerButton.textContent = 'Đang đăng ký...';

            const formData = new FormData(registerForm);

            fetch('/dang-ky', {
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
                            text: 'Đăng ký tài khoản thành công.',
                            icon: 'success',
                            button: "OK",
                        });

                        setTimeout(() => {
                            window.location.href = '/';
                        }, 1000);
                    }
                });

            registerButton.disabled = false;
            registerButton.textContent = 'Đăng ký';
        });
    });
</script>
