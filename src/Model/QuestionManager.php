<?php

namespace App\Model;

class QuestionManager extends AbstractManager
{
    public const TABLE = 'question';

    public function selectRandomQuestion(): array
    {
        $query = ("SELECT * FROM " . static::TABLE . " ORDER BY rand() LIMIT 1");
        return $this->pdo->query($query)->fetch();
    }

    public function addQuestion(string $question, int $timeLimit): int
    {
        $query = "INSERT INTO " . static::TABLE . " (title, timelimit) VALUES (:question, :timelimit)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':question', $question, \PDO::PARAM_STR);
        $statement->bindValue(':timelimit', $timeLimit, \PDO::PARAM_STR);
        $statement->execute();
        return $this->selectLastQuestion()["id"];
    }

    public function selectLastQuestion(): array
    {
        $query = ("SELECT * FROM " . static::TABLE . " ORDER BY id DESC LIMIT 1");
        return $this->pdo->query($query)->fetch();
    }
}
