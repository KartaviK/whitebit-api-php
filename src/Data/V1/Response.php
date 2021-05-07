<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

/** @template T */
class Response
{
    /**
     * @param T $result
     * @param array $errors
     */
    public function __construct(
        private bool $success,
        private mixed $result,
        private string $message = '',
        private array $errors = []
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    /** @return mixed */
    public function getResult(): mixed
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
