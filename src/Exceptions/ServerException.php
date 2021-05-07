<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Exceptions;

use Http\Client\Exception\HttpException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Kartavik\WhiteBIT\Api\Exception;

class ServerException extends HttpException implements Exception
{
    public function __construct(
        protected array $errors,
        RequestInterface $request,
        ResponseInterface $response,
        ?\Exception $previous = null
    ) {
        parent::__construct('Internal server error', $request, $response, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
