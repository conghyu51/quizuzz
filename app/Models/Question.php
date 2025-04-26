<?php

namespace App\Models;

abstract class Question
{
    protected int $id;
    protected int $quiz_id;
    protected string $content;
    protected string $type;
    protected int $points = 1;

    public function setQuizId(int $quiz_id): self
    {
        $this->quiz_id = $quiz_id;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setPoint(int $point): self
    {
        $this->points = $point;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function save(): bool
    {
        global $db;

        $data = [
            'quiz_id' => $this->quiz_id,
            'content' => $this->content,
            'type' => $this->type,
            'points' => $this->points,
        ];

        $result = $db->create('questions', $data);

        if ($result) {
            $this->id = $db->raw("SELECT LAST_INSERT_ID()")->fetch_row()[0];

            return $this->id;
        }

        return false;
    }

    abstract public function saveAnswers(array $answers);
}
