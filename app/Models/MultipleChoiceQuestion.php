<?php

namespace App\Models;

class MultipleChoiceQuestion extends Question
{
    public function __construct()
    {
        $this->setType('multiple_choice');
    }

    public function saveAnswers(array $answers): void
    {
        global $db;

        $correctExists = false;

        foreach ($answers as $_ => $answer) {
            if (isset($answer['is_correct']) && $answer['is_correct']) {
                $correctExists = true;
            }

            $db->create('options', [
                'question_id' => $this->getId(),
                'content' => $answer['content'],
                'is_correct' => intval($answer['is_correct']) ?? 0,
            ]);
        }

        if (!$correctExists) {
            throw new \Exception("Phải có ít nhất một đáp án đúng");
        }
    }
}
