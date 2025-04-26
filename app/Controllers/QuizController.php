<?php

namespace App\Controllers;

use Respect\Validation\Validator as v;

class QuizController extends BaseController
{
    public function createNewQuiz(): mixed
    {
        global $db;

        $quizName = $_POST['quizName'] ?? null;
        $image = $_POST['image'] ?? null;
        $durationMinutes = $_POST['durationMinutes'] ?? null;
        $isPublic = $_POST['isPublic'] ?? null;

        if (!v::stringType()->notEmpty()->validate($quizName)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Tên quiz không được để trống.',
            ]);
        }

        if (!v::stringType()->notEmpty()->validate($image)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Link ảnh bìa không được để trống.',
            ]);
        }

        if (!v::boolType()->validate(boolval($isPublic))) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Công khai phải là có hoặc không.',
            ]);
        }

        if (intval($durationMinutes) < 0 || $durationMinutes > 65535) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Giới hạn thời gian chỉ từ 0 đến 65535 phút.',
            ]);
        }

        $slug = $this->generateSlug($quizName);

        if ($db->get('quizzes', "`slug` = '$slug'")) {
            $slug = $slug . '-' . time();
        }

        $db->create('quizzes', [
            'name' => $quizName,
            'image' => $image,
            'slug' => $slug,
            'duration_minutes' => $durationMinutes,
            'is_public' => intval($isPublic),
            'user_id' => $_SESSION['user']['id'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->responseJson([
            'ok' => true,
            'redirect' => "/thu-vien-cua-toi?quiz=$slug&action=edit",
        ]);
    }

    public function saveQuiz(): mixed
    {
        global $db;

        $quizName = $_POST['quizName'] ?? null;
        $image = $_POST['image'] ?? null;
        $durationMinutes = $_POST['durationMinutes'] ?? null;
        $isPublic = $_POST['isPublic'] ?? null;

        if (!v::stringType()->notEmpty()->validate($quizName)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Tên quiz không được để trống.',
            ]);
        }

        if (!v::stringType()->notEmpty()->validate($image)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Link ảnh bìa không được để trống.',
            ]);
        }

        if (!v::boolType()->validate(boolval($isPublic))) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Công khai phải là có hoặc không.',
            ]);
        }

        if (intval($durationMinutes) < 0 || $durationMinutes > 65535) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Giới hạn thời gian chỉ từ 0 đến 65535 phút.',
            ]);
        }

        $slug = $this->generateSlug($quizName);

        if ($db->get('quizzes', "`slug` = '$slug' AND `id` != '{$_GET['quizId']}'")) {
            $slug = $slug . '-' . time();
        }

        $db->update(
            'quizzes',
            [
                'name' => $quizName,
                'image' => $image,
                'slug' => $slug,
                'duration_minutes' => $durationMinutes,
                'is_public' => boolval($isPublic) ? 1 : 0,
            ],
            "`id` = '{$_GET['quizId']}' AND `user_id` = {$_SESSION['user']['id']}"
        );

        return $this->responseJson([
            'ok' => true,
            'msg' => 'Lưu quiz thành công',
            'redirect' => "/thu-vien-cua-toi?quiz=$slug&action=edit",
        ]);
    }

    protected function generateSlug(string $title): string
    {
        $title = preg_replace([
            '/[àáạảãâầấậẩẫăằắặẳẵ]/u',
            '/[èéẹẻẽêềếệểễ]/u',
            '/[ìíịỉĩ]/u',
            '/[òóọỏõôồốộổỗơờớợởỡ]/u',
            '/[ùúụủũưừứựửữ]/u',
            '/[ỳýỵỷỹ]/u',
            '/[đ]/u',
            '/[ÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/u',
            '/[ÈÉẸẺẼÊỀẾỆỂỄ]/u',
            '/[ÌÍỊỈĨ]/u',
            '/[ÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/u',
            '/[ÙÚỤỦŨƯỪỨỰỬỮ]/u',
            '/[ỲÝỴỶỸ]/u',
            '/[Đ]/u',
            '/[^a-zA-Z0-9\s]/u'
        ], [
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '',
        ], $title);

        $title = strtolower($title);
        $title = preg_replace('/[\s\-]+/', '-', $title);

        return trim($title, '-');
    }

    public function deleteQuizById()
    {
        global $db;

        $quizId = $_GET['quizId'] ?? '';

        if (empty($quizId)) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'ID quiz không được để trống',
            ]);
        }

        $quiz = $db->get('quizzes', "`id` = '{$quizId}' AND `user_id` = {$_SESSION['user']['id']}");
        if (!$quiz) {
            return $this->responseJson([
                'ok' => false,
                'msg' => 'Không thể xóa câu hỏi này',
            ]);
        }

        $db->delete('quizzes', "`id` = '{$quizId}' AND `user_id` = {$_SESSION['user']['id']}");

        return $this->responseJson([
            'ok' => true,
            'msg' => 'Xóa quiz thành công',
        ]);
    }
}
