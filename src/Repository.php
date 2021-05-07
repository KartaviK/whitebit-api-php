<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Http\Promise\Promise;

/**
 * @psalm-import-type MarketInfoV1Data from Action
 */
class Repository implements Contracts\RepositoryContract, Contracts\RepositoryAsyncAwareContract
{
    public function __construct(
        private Contracts\HttpContract $http,
        private ?Contracts\ParserContract $parser = null
    ) {
    }

    public function getMarketsInfo(Version $version): iterable
    {
        return match (true) {
            $version->equals(Version::V_1()) => $this->getMarketsInfoV1(),
            default => throw new Exceptions\UnprocessableVersionException(Action::MARKETS, $version),
        };
    }

    public function getMarketsInfoV1(): iterable
    {
        return $this->getMarketsInfoV1Async()->wait();
    }

    public function getMarketsInfoV1Async(): Promise
    {
        return $this->http->get(Version::V_1(), Contracts\HttpContract::PUBLIC_API, Action::MARKETS)
            ->then(fn (array $result): iterable => $this->parse(
                $result,
                static fn (
                    Contracts\ParserContract $parser,
                    array $data
                ): iterable => $parser->parseMarketInfoV1Collection($data)
            ));
    }

    public function getMarketsActivityV1(): iterable
    {
        return $this->getMarketsActivityV1Async()->wait();
    }

    public function getMarketsActivityV1Async(): Promise
    {
        return $this->http->get(Version::V_1(), Contracts\HttpContract::PUBLIC_API, Action::TICKERS)
            ->then(fn (array $result): iterable => $this->parse(
                $result,
                static fn (
                    Contracts\ParserContract $parser,
                    array $data
                ): iterable => $parser->parseMarketActivityV1Collection($data)
            ));
    }

    public function parse(array $data, \Closure $parse): iterable
    {
        return $this->parser !== null
            ? $parse($this->parser, $data)
            : $data;
    }
}
