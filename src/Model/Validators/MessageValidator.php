<?php

namespace App\Model\Validators;

class MessageValidator implements ValidatorInterface
{
    private const NOT_EMPTY_FIELDS = ['text'];
    private const MIN_TEXT_LENGTH = 1;
    private const MAX_TEXT_LENGTH = 4096;

    public function validate(array $data): array
    {
        $errors = $this->validateNotEmpty($data);

        if (!empty($errors)) {
            return $errors;
        }

        return array_merge(
            $this->validateLength($data),
        );
    }

    private function validateNotEmpty(array $data): array
    {
        $errors = [];

        foreach (self::NOT_EMPTY_FIELDS as $fieldName) {
            $value = $data[$fieldName] ?? null;

            if (empty($value)) {
                $errors[$fieldName] = 'Поле "' . $fieldName . '" не должно быть пустым';
            }
        }

        return $errors;
    }

    private function validateLength(array $data): array
    {
        $textLength = mb_strlen($data['text']);

        if ($textLength < self::MIN_TEXT_LENGTH) {
            return [
                'text' => 'Текст не может быть меньше ' . self::MIN_TEXT_LENGTH . ' символов',
            ];
        }

        if ($textLength > self::MAX_TEXT_LENGTH) {
            return [
                'text' => 'Текст не может быть больше ' . self::MAX_TEXT_LENGTH . ' символов',
            ];
        }

        return [];
    }
}
