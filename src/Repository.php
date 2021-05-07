<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Http\Promise\Promise;
use Kartavik\WhiteBIT\Api\Data\V1\Response;
use Psr\Http\Message\ResponseInterface;

use function Safe\json_decode;

class Repository
{
    public function __construct(
        private Contracts\HttpContract $http,
        private ?Contracts\ParserContract $parser = null
    ) {}

    public function getMarketsInfoV1(): Data\V1\Response
    {
        return $this->getMarketsInfoV1Async()->wait();
    }

    public function getMarketsInfoV1Async(): Promise
    {
        return $this->http->get(Contracts\HttpContract::VERSION_1, Contracts\HttpContract::PUBLIC_API, Action::MARKETS)
            ->then(function (ResponseInterface $response): Data\V1\Response {
                [$success, $result, $message, $params] = $this->decodeBody($response);
                $parsed = $this->parse(
                    $result,
                    static fn (
                        Contracts\ParserContract $parser,
                        array $data
                    ): array => $parser->parseMarketInfoV1Collection($data)
                );

                return $this->buildResponse(
                    $success,
                    $parsed,
                    $message,
                    $params
                );
            });
    }

    private function buildResponse(bool $success, mixed $data, string $message, array $params): Data\V1\Response
    {
        return new Response($success, $data, $message, $params);
    }

    public function parse(array $data, \Closure $parse): mixed
    {
        return $this->parser !== null
            ? $parse($this->parser, $data)
            : null;
    }

    /** @return array{0: bool, 1: mixed[], 2: string, 3: mixed[]} */
    private function decodeBody(ResponseInterface $response): array
    {
        $data = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        /**
         * @var bool $success
         * @var array $result
         * @var string $message
         */
        [
            'success' => $success,
            'result' => $result,
            'message' => $message,
        ] = $data;
        /** @var array $params */
        $params = $data['params'] ?? [];

        return [$success, $result, $message, $params];
    }
}
