<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Http\Promise\Promise;

interface RepositoryAsyncAwareContract
{
    public function getMarketsInfoV1Async(): Promise;

    public function getMarketsActivityV1Async(): Promise;

    public function getSingleMarketActivityV1Async(string $stock, string $money): Promise;

    public function getKlineAsync(
        string $stock,
        string $money,
        ?int $start = null,
        ?int $end = null,
        string $interval = '1h',
        int $limit = 1440
    ): Promise;

    public function getSymbolsV1Async(): Promise;

    public function getTradeHistoryV1Async(string $stock, string $money, int $lastId, int $limit = 50): Promise;
}
