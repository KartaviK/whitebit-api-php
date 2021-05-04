<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Tests;

use GuzzleHttp\Psr7\Request;

class RequestFactory implements \Http\Message\RequestFactory
{
    public function createRequest($method, $uri, array $headers = [], $body = null, $protocolVersion = '1.1'): Request
    {
        return new Request($method, $uri, $headers, $body, $protocolVersion);
    }
}
