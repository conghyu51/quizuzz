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

        $db->create('text_answers', [
            'question_id' => $this->id,
            'content' => $answers['content'],
        ]);
    }
}
