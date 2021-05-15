<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Carbon\Carbon;
use Http\Promise\Promise;
use Kartavik\WhiteBIT\Api\Contracts\Data\PairContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\MarketActivityContract;
use Kartavik\WhiteBIT\Api\Data\V1\MarketActivity;

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
                fn (array $data): iterable => $this->parser->parseMarketInfoV1Collection($data)
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
                fn (array $data): iterable => $this->parser->parseMarketActivityV1Collection($data)
            ));
    }

    public function getSingleMarketActivityV1(PairContract $pair): MarketActivityContract
    {
        return $this->getSingleMarketActivityV1Async($pair)->wait();
    }

    public function getSingleMarketActivityV1Async(PairContract $pair): Promise
    {
        return $this->http->get(Version::V_1(), Contracts\HttpContract::PUBLIC_API, Action::TICKER, [
            'market' => $pair->getMarketName(),
        ])->then(fn (array $result): MarketActivityContract => $this->parse(
            $result,
            fn (array $data): MarketActivity => $this->parser->parseSingleMarketActivity($data, $pair)
        ));
    }

    public function getKline(
        PairContract $pair,
        ?int $start = null,
        ?int $end = null,
        string $interval = Interval::DEFAULT,
        int $limit = 1440
    ): iterable {
        return $this->getKlineAsync($pair, $start, $end, $interval, $limit)->wait();
    }

    public function getKlineAsync(
        PairContract $pair,
        ?int $start = null,
        ?int $end = null,
        string $interval = Interval::DEFAULT,
        int $limit = 1440
    ): Promise {
        return $this->http->get(Version::V_1(), Contracts\HttpContract::PUBLIC_API, Action::KLINE, [
            'market' => $pair->getMarketName(),
            'start' => $start ?? Carbon::now()->startOfDay()->getTimestamp(),
            'end' => $end ?? Carbon::now()->getTimestamp(),
            'interval' => $interval,
            'limit' => $limit,
        ])->then(fn (array $result): iterable => $this->parse(
            $result,
            fn (array $data): iterable => $this->parser->parseKlineCollection($data, $pair)
        ));
    }

    public function getSymbolsV1(): iterable
    {
        return $this->getSymbolsV1Async()->wait();
    }

    public function getSymbolsV1Async(): Promise
    {
        return $this->http->get(Version::V_1(), Contracts\HttpContract::PUBLIC_API, Action::SYMBOLS)
            ->then(fn (array $result): iterable => $this->parse(
                $result,
                fn (array $data) => $this->parser->parseMarketCollection($data)
            ));
    }

    public function getTradeHistoryV1(PairContract $pair, int $lastId, int $limit = 50): iterable
    {
        return $this->getTradeHistoryV1Async($pair, $lastId, $limit)->wait();
    }

    public function getTradeHistoryV1Async(PairContract $pair, int $lastId, int $limit = 50): Promise
    {
        return $this->http->get(Version::V_1(), Contracts\HttpContract::PUBLIC_API, Action::HISTORY, [
            'market' => $pair->getMarketName(),
            'lastId' => $lastId,
            'limit' => $limit,
        ])->then(fn (array $result): iterable => $this->parse(
            $result,
            fn (array $data) => $this->parser->parseTradeHistoryCollection($pair, $data)
        ));
    }

    public function parse(array $data, callable $parse): mixed
    {
        return $this->parser !== null ? $parse($data) : $data;
    }
}
