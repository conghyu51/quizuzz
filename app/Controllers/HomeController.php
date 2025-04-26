<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): void
    {
        global $db;

        $quizzes = [];
        $fetchQuizzes = $db->raw("SELECT quizzes.*, users.username FROM `quizzes` JOIN users ON quizzes.user_id = users.id WHERE quizzes.is_public = 1 ORDER BY quizzes.created_at DESC");
        foreach ($fetchQuizzes as $quiz) {
            $quizzes[] = [
                'id' => $quiz['id'],
                'name' => $quiz['name'],
                'slug' => $quiz['slug'],
                'play' => $quiz['play'],
                'image' => $quiz['image'],
                'created_at' => $quiz['created_at'],
                'username' => $quiz['username'],
            ];
        }

        $this->render('home', [
            'title' => 'Khám phá',
            'quizzes' => $quizzes,
        ]);
    }
}
