<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Kartavik\WhiteBIT\Api\Contracts\Data\V1\MarketActivityContract;

interface RepositoryContract
{
    public function getMarketsInfoV1(): iterable;

    public function getMarketsActivityV1(): iterable;

    public function getSingleMarketActivityV1(string $stock, string $money): MarketActivityContract;

    public function getKline(
        string $stock,
        string $money,
        ?int $start = null,
        ?int $end = null,
        string $interval = '1h',
        int $limit = 1440
    ): iterable;

    public function getSymbolsV1(): iterable;

    public function getTradeHistoryV1(string $stock, string $money, int $lastId, int $limit = 50): iterable;
}
