<div class="card card-md">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Đăng nhập</h2>
        <form autocomplete="off" id="loginForm">
            <div class="mb-3">
                <label class="form-label" for="username">
                    Tên đăng nhập
                </label>
                <input type="text" class="form-control" autocomplete="off" id="username" name="username" placeholder="quizuzz" autofocus />
            </div>
            <div class="mb-2">
                <label class="form-label" for="password">
                    Mật khẩu
                </label>
                <div class="input-group input-group-flat">
                    <input type="password" class="form-control" autocomplete="off" id="password" name="password" placeholder="••••••••" />
                </div>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100" id="loginButton">
                    Đăng nhập
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');

        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            loginButton.disabled = true;
            loginButton.textContent = 'Đang đăng nhập...';

            const formData = new FormData(loginForm);

            fetch('/dang-nhap', {
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
                        window.location.href = '/';
                    }
                });

            loginButton.disabled = false;
            loginButton.textContent = 'Đăng nhập';
        });
    });
</script>
<div class="text-center text-secondary mt-3">
    Không có tài khoản? <a href="/dang-ky" tabindex="-1">Đăng ký ngay</a>
</div>
