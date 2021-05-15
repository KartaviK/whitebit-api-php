<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Http\Promise\Promise;
use Kartavik\WhiteBIT\Api\Contracts\Data\PairContract;
use Kartavik\WhiteBIT\Api\Interval;

interface RepositoryAsyncAwareContract
{
    public function getMarketsInfoV1Async(): Promise;

    public function getMarketsActivityV1Async(): Promise;

    public function getSingleMarketActivityV1Async(PairContract $pair): Promise;

    public function getKlineAsync(
        PairContract $pair,
        ?int $start = null,
        ?int $end = null,
        string $interval = Interval::DEFAULT,
        int $limit = 1440
    ): Promise;

    public function getSymbolsV1Async(): Promise;

    public function getTradeHistoryV1Async(PairContract $pair, int $lastId = 1, int $limit = 50): Promise;
}
