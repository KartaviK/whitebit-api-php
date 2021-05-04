<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

/** @template T of object|array */
class Response
{
    /** @param T[] $result */
    public function __construct(
        private bool $success,
        private array $result,
        private string $message = '',
        private array $errors = []
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    /** @return T[] */
    public function getResult(): array
    {
        return $this->result;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
