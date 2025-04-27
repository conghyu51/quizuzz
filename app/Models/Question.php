<?php

namespace App\Models;

abstract class Question
{
    protected int $id;
    protected string $content;
    protected string $type;
    protected int $quiz_id;
    protected int $points = 1;

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setQuizId(int $quiz_id): self
    {
        $this->quiz_id = $quiz_id;

        return $this;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function save(): bool
    {
        global $db;

        // tạo record mới
        $result = $db->create('questions', [
            'content' => $this->content,
            'type' => $this->type,
            'quiz_id' => $this->quiz_id,
            'points' => $this->points,
        ]);

        if ($result) {
            $this->id = $db->raw("SELECT LAST_INSERT_ID()")->fetch_row()[0];

            return $this->id;
        }

        return false;
    }

    abstract public function saveAnswers(array $answers);
}
