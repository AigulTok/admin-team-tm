<?php

namespace App\Model\Entity;

class Message
{
    private ?int $id;
    private ?string $text;
    private ?string $date;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->text = $data['text'] ?? null;
        $this->date = $data['date'] ?? null;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getText() : string
    {
        return $this->text ?? '';
    }

    public function getDate() : string
    {
        return $this->date ?? '';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'text' => $this->getText(),
            'date' => $this->getDate(),
        ];
    }
}
