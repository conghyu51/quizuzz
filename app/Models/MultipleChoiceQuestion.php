<?php

namespace App\Models;

class MultipleChoiceQuestion extends Question
{
    public function __construct()
    {
        $this->setType('multiple_choice');
    }

    public function saveAnswers(array $answers)
    {
        global $db;

        $correctExists = false;

        foreach ($answers as $_ => $answer) {
            if (isset($answer['is_correct']) && $answer['is_correct']) {
                $correctExists = true;
            }

            $data = [
                'question_id' => $this->id,
                'content' => $answer['content'],
                'is_correct' => intval($answer['is_correct']) ?? 0,
            ];

            $db->create('options', $data);
        }

        if (!$correctExists) {
            throw new \Exception("Phải có ít nhất một đáp án đúng");
        }
    }
}
