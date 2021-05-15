<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Doctrine\Common\Collections\Collection;
use Kartavik\WhiteBIT\Api\Contracts\Data\PairContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\MarketActivityContract;
use Kartavik\WhiteBIT\Api\Interval;

interface RepositoryContract
{
    public function getMarketsInfoV1(): Collection|array;

    public function getMarketsActivityV1(): Collection|array;

    public function getSingleMarketActivityV1(PairContract $pair): MarketActivityContract|array;

    public function getKline(
        PairContract $pair,
        ?int $start = null,
        ?int $end = null,
        string $interval = Interval::DEFAULT,
        int $limit = 1440
    ): iterable;

    public function getSymbolsV1(): Collection|array;

    public function getTradeHistoryV1(PairContract $pair, int $lastId = 1, int $limit = 50): Collection|array;
}
