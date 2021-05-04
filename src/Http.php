<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Http\Client\HttpAsyncClient;
use Http\Message\RequestFactory;
use Http\Promise\Promise;
use Psr\Http\Message\ResponseInterface;

use function http_build_query;
use function Safe\json_decode;

class Http implements Contracts\HttpContract
{
    public function __construct(
        private HttpAsyncClient $http,
        private RequestFactory $factory,
        private string $uri = self::BASE_URI
    ) {
    }

    public function get(string $version, string $type, string $api, array $params = [], array $headers = []): Promise
    {
        $request = $this->factory->createRequest(
            'GET',
            $this->getUrl($version, $type, $api, $params),
            $headers
        );

        return $this->http->sendAsyncRequest($request);
//            ->then(function (ResponseInterface $response) use ($request): array {
//                return $response
//                $payload = $this->parseBody($response);
//
////                if (isset($payload['success']) && !$payload['success']) {
////                    throw new Exceptions\RequestException($payload['message'], $request);
////                }
////
////                if (!isset($payload['result']) && isset($payload['status'])) {
////                    throw new Exceptions\InternalException($payload['errors'], $request, $response);
////                }
//
//                return $payload['result'];
//            });
    }

    private function parseBody(ResponseInterface $response): array
    {
        return (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    private function getUrl(string $version, string $type, string $api, array $params = []): string
    {
        $parametersQuery = !empty($params) ? '?' . http_build_query($params) : '';

        return "{$this->uri}/{$version}/{$type}/{$api}{$parametersQuery}";
    }
}