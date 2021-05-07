<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Exceptions;

use Kartavik\WhiteBIT\Api\Exception;

class ClientException extends \RuntimeException implements Exception
{
    public function __construct(protected array $errors, int $code = 0, ?\Exception $previous = null)
    {
        parent::__construct('Client exception', $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
