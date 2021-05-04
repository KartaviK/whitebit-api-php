<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Http\Promise\Promise;
use Psr\Http\Message\ResponseInterface;

class Repository
{
    public function __construct(
        private Contracts\HttpContract $http,
        private Contracts\ParserContract $parser
    ) {
    }

    public function getMarketsInfoV1Async(): Promise
    {
        return $this->http->get(Contracts\HttpContract::VERSION_1, Contracts\HttpContract::PUBLIC_API, Action::MARKETS)
            ->then(fn (
                ResponseInterface $response
            ): Data\V1\Response => $this->parser->parseMarketInfoV1Collection($response));
    }
}
