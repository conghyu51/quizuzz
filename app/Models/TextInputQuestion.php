<?php

namespace App\Models;

class TextInputQuestion extends Question
{
    public function __construct()
    {
        $this->setType('text_input');
    }

    public function saveAnswers(array $answers): void
    {
        global $db;

        $answer = $answers['content'];

        $data = [
            'question_id' => $this->id,
            'content' => $answer,
        ];

        $db->create('text_answers', $data);
    }
}
