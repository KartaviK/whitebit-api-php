<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Http\Promise\Promise;
use Kartavik\WhiteBIT\Api\Data\V1\Response;
use Psr\Http\Message\ResponseInterface;

class Repository
{
    public function __construct(
        private Contracts\HttpContract $http,
        private Contracts\ParserContract $parser
    ) {
    }

    public function getMarketsInfoV1(): Data\V1\Response
    {
        return $this->getMarketsInfoV1Async()->wait();
    }

    public function getMarketsInfoV1Async(): Promise
    {
        return $this->http->get(Contracts\HttpContract::VERSION_1, Contracts\HttpContract::PUBLIC_API, Action::MARKETS)
            ->then(fn (
                ResponseInterface $response
            ): Data\V1\Response => $this->wrapResponse($this->parser->parseMarketInfoV1Collection($response)));
    }

    private function wrapResponse(array $data): Data\V1\Response
    {
        return new Response($data['success'], $data['result'], $data['message'] ?? '', $data['params'] ?? []);
    }
}
