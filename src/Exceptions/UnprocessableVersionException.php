<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Exceptions;

use Kartavik\WhiteBIT\Api\Exception;
use Kartavik\WhiteBIT\Api\Version;

class UnprocessableVersionException extends \LogicException implements Exception
{
    public function __construct(
        private string $api,
        private Version $version,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            "Given api version [{$version->getValue()}] for endpoint [{$api}] is not supported",
            $code,
            $previous
        );
    }

    public function getApi(): string
    {
        return $this->api;
    }

    public function getVersion(): Version
    {
        return $this->version;
    }
}
