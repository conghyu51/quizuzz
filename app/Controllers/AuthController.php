<?php

namespace App\Controllers;

use Respect\Validation\Validator as v;

class AuthController extends BaseController
{
    public function loginPage(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $this->render('auth/login', [
            'title' => 'Đăng nhập',
            'layout' => 'auth',
        ]);
    }

    public function login(): mixed
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!v::stringType()->notEmpty()->validate($username)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Tên đăng nhập không được để trống.',
            ]);
        }

        if (!v::stringType()->notEmpty()->validate($password)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Mật khẩu không được để trống.',
            ]);
        }

        if (!$user = $this->authenticateUser($username, $password)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Thông tin đăng nhập không đúng.',
            ]);
        }

        global $db;

        $db->update('users', [
            'last_login_at' => date('Y-m-d H:i:s'),
        ], "`username` = '$username'");

        $_SESSION['user'] = $user;

        return $this->responseJson(['ok' => true]);
    }

    protected function authenticateUser($username, $password): false|array
    {
        global $db;

        if (is_null($user = $db->get('users', "username = '$username'"))) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }

    public function registerPage(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $this->render('auth/register', [
            'title' => 'Đăng ký tài khoản',
            'layout' => 'auth',
            'hideIllustration' => true,
        ]);
    }

    public function register(): mixed
    {
        global $db;

        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $passwordConfirmation = $_POST['passwordConfirmation'] ?? null;

        if (!v::stringType()->notEmpty()->validate($username)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Tên đăng nhập không được để trống.',
            ]);
        }

        if (!v::stringType()->notEmpty()->validate($password)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Mật khẩu không được để trống.',
            ]);
        }

        if (!v::alnum()->noWhitespace()->length(6, 20)->validate($username)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Tên đăng nhập chỉ được chứa chữ và số. Độ dài từ 6 đến 20 ký tự.',
            ]);
        }

        if (!v::length(6, 64)->validate($password)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Mật khẩu phải có độ dài từ 6 đến 64 ký tự.',
            ]);
        }

        if ($password !== $passwordConfirmation) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Mật khẩu nhập lại không khớp.',
            ]);
        }

        if ($db->get('users', "username = '$username'")) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Tên đăng nhập đã được sử dụng.',
            ]);
        }

        $db->create('users', [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $_SESSION['user'] = $db->get('users', "username = '$username'");

        return $this->responseJson(['ok' => true]);
    }

    public function logout(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header('Location: /');
        exit;
    }
}
