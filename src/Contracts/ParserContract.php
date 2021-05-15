<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Doctrine\Common\Collections\Collection;
use Kartavik\WhiteBIT\Api;

/**
 * @psalm-import-type MarketInfoV1Data from Api\Action
 * @psalm-import-type MarketActivityV1Data from Api\Action
 * @psalm-import-type MarketActivity from Api\Action
 * @psalm-import-type KlineItem from Api\Action
 * @psalm-import-type TradeHistoryItem from Api\Action
 */
interface ParserContract
{
    /**
     * @param MarketInfoV1Data $data
     */
    public function parseMarketInfoV1(array $data): Api\Contracts\Data\V1\MarketInfoContract;

    /**
     * @param list<MarketInfoV1Data> $data
     *
     * @return Collection<int, Api\Contracts\Data\V1\MarketInfoContract>
     */
    public function parseMarketInfoV1Collection(array $data): Collection;

    /**
     * @param MarketActivityV1Data $data
     */
    public function parseMarketActivityV1(array $data, string $name): Api\Contracts\Data\V1\MarketActivityContract;

    /**
     * @param array<string, MarketActivityV1Data> $data
     * @return Collection<int, Api\Contracts\Data\V1\MarketActivityContract>
     */
    public function parseMarketActivityV1Collection(array $data): Collection;

    /**
     * @param MarketActivity $data
     */
    public function parseSingleMarketActivity(array $data, string $name): Api\Data\V1\MarketActivity;

    /**
     * @param KlineItem $data
     */
    public function parseKline(array $data): Api\Contracts\Data\V1\KlineContract;

    /**
     * @param list<KlineItem> $data
     */
    public function parseKlineCollection(array $data, string $name): Collection;

    /**
     * @return Api\Contracts\Data\V1\MarketContract
     */
    public function parseMarket(string $marketName): Api\Contracts\Data\V1\MarketContract;

    /**
     * @param list<string> $data
     * @return Collection<int, Api\Contracts\Data\V1\MarketContract>
     */
    public function parseMarketCollection(array $data): Collection;

    /**
     * @param TradeHistoryItem $item
     */
    public function parseTradeHistoryItem(array $item): Api\Contracts\Data\V1\TradeHistoryItemContract;

    /**
     * @param list<TradeHistoryItem> $data
     * @return Collection<int, Api\Contracts\Data\V1\TradeHistoryItemContract>
     */
    public function parseTradeHistoryCollection(string $market, array $data): Collection;
}
