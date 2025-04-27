<?php

namespace App\Models;

abstract class Question
{
    protected int $id;
    protected string $content;
    protected string $type;
    protected int $quiz_id;
    protected int $points = 1;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuizId(): int
    {
        return $this->quiz_id;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function save(): bool
    {
        global $db;

        // tạo record mới
        $result = $db->create('questions', [
            'content' => $this->getContent(),
            'type' => $this->getType(),
            'quiz_id' => $this->getQuizId(),
            'points' => $this->getPoints(),
        ]);

        if ($result) {
            $this->setId($db->raw("SELECT LAST_INSERT_ID()")->fetch_row()[0]);

            return $this->getId();
        }

        return false;
    }

    abstract public function saveAnswers(array $answers);
}
