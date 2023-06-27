<?php

namespace App\Model\Repository;

use App\Model\Entity\Message;
use PDO;

class MessageRepository extends Dbh
{
    public function getAll()
    {
        $result = [];

        $stmt = $this->connect()->query('SELECT text, date FROM messages;');
        $query = $stmt->fetchAll(PDO::FETCH_DEFAULT);

        foreach ($query as $data) {
            $result[] = new Message($data);
        }

        return $result;
    }

    public function read(int $id)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM messages WHERE id = :id;');

        $stmt->bindValue("id", $id);
        $stmt->execute();

        $query = $stmt->fetch(PDO::FETCH_DEFAULT);

        return new Message(json_decode(json_encode($query), true));
    }

    public function create(array $data)
    {
        $stmt = $this->connect()->prepare('INSERT INTO messages (text) VALUES (:text);');

        $stmt->bindValue("text", $data['text'], PDO::PARAM_STR);

        $stmt->execute();

        return new Message($data);

    }
}
