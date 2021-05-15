<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Kartavik\WhiteBIT\Api;
use Kartavik\WhiteBIT\Api\Contracts\AmountFactoryContract;

/**
 * @psalm-import-type MarketInfoV1Data from Action
 * @psalm-import-type MarketActivityV1Data from Action
 * @psalm-import-type KlineItem from Action
 */
class Parser implements Api\Contracts\ParserContract
{
    public const KLINE_TIME = 0;
    public const KLINE_OPEN = 1;
    public const KLINE_CLOSE = 2;
    public const KLINE_HIGH = 3;
    public const KLINE_LOW = 4;
    public const KLINE_VOLUME_STOCK = 5;
    public const KLINE_VOLUME_MONEY = 6;

    public function __construct(private AmountFactoryContract $amountFactory)
    {
    }

    /** {@inheritDoc} */
    public function parseMarketInfoV1(array $data): Data\V1\MarketInfo
    {
        return new Data\V1\MarketInfo(
            $data['name'],
            $this->amountFactory->build($data['moneyPrec']),
            $data['stock'],
            $data['money'],
            $this->amountFactory->build($data['stockPrec']),
            $this->amountFactory->build($data['feePrec']),
            $this->amountFactory->build($data['minAmount']),
            $this->amountFactory->build($data['makerFee']),
            $this->amountFactory->build($data['takerFee'])
        );
    }

    /** @return ArrayCollection<int, Data\V1\MarketInfo> */
    public function parseMarketInfoV1Collection(array $data): ArrayCollection
    {
        return $this->map($data, fn (array $arg): Data\V1\MarketInfo => $this->parseMarketInfoV1($arg));
    }

    /** {@inheritDoc} */
    public function parseMarketActivityV1(
        array $data,
        Api\Contracts\Data\PairContract $market
    ): Api\Contracts\Data\V1\MarketActivityContract {
        $ticker = $data['ticker'];

        return new Api\Data\V1\MarketActivity(
            $market,
            (int) $data['at'],
            $this->amountFactory->build($ticker['ask']),
            $this->amountFactory->build($ticker['bid']),
            $this->amountFactory->build($ticker['low']),
            $this->amountFactory->build($ticker['high']),
            $this->amountFactory->build($ticker['last']),
            $this->amountFactory->build($ticker['vol']),
            $this->amountFactory->build($ticker['deal']),
            $this->amountFactory->build($ticker['change']),
        );
    }

    /** @return ArrayCollection<int, Api\Data\V1\MarketActivity> */
    public function parseMarketActivityV1Collection(array $data): ArrayCollection
    {
        return $this->map(
            $data,
            fn (array $arg, string $name): Api\Data\V1\MarketActivity => $this->parseMarketActivityV1(
                $arg,
                $this->parseMarket($name)
            )
        );
    }

    public function parseSingleMarketActivity(
        array $data,
        Api\Contracts\Data\PairContract $market
    ): Api\Data\V1\MarketActivity {
        return new Api\Data\V1\MarketActivity(
            $market,
            Carbon::now()->getTimestamp(),
            $this->amountFactory->build($data['ask']),
            $this->amountFactory->build($data['bid']),
            $this->amountFactory->build($data['low']),
            $this->amountFactory->build($data['high']),
            $this->amountFactory->build($data['last']),
            $this->amountFactory->build($data['volume']),
            $this->amountFactory->build($data['deal']),
            $this->amountFactory->build($data['change']),
        );
    }

    public function parseKline(array $data): Api\Contracts\Data\V1\KlineContract
    {
        return new Api\Data\V1\Kline(
            $data[self::KLINE_TIME],
            $this->amountFactory->build($data[self::KLINE_OPEN]),
            $this->amountFactory->build($data[self::KLINE_CLOSE]),
            $this->amountFactory->build($data[self::KLINE_HIGH]),
            $this->amountFactory->build($data[self::KLINE_LOW]),
            $this->amountFactory->build($data[self::KLINE_VOLUME_STOCK]),
            $this->amountFactory->build($data[self::KLINE_VOLUME_MONEY]),
        );
    }

    public function parseKlineCollection(
        array $data,
        Api\Contracts\Data\PairContract $market
    ): Api\Data\V1\KlineCollection {
        return new Api\Data\V1\KlineCollection(
            $market,
            ...$this->map($data, fn (array $arg) => $this->parseKline($arg))->toArray()
        );
    }

    public function parseMarket(string $marketName): Api\Data\V1\Market
    {
        [$stock, $money] = explode('_', $marketName);

        return new Api\Data\V1\Market($stock, $money);
    }

    public function parseMarketCollection(array $data): ArrayCollection
    {
        return $this->map($data, fn (string $market): Api\Data\V1\Market => $this->parseMarket($market));
    }

    public function parseTradeHistoryItem(array $item): Api\Contracts\Data\V1\TradeHistoryItemContract
    {
        return new Api\Data\V1\TradeHistoryItem(
            $item['id'],
            $item['type'],
            $item['time'],
            $this->amountFactory->build($item['amount']),
            $this->amountFactory->build($item['price'])
        );
    }

    public function parseTradeHistoryCollection(
        Api\Contracts\Data\PairContract $market,
        int $lastId,
        array $data
    ): Api\Data\V1\TradeHistoryCollection {
        return new Api\Data\V1\TradeHistoryCollection(
            $market,
            $lastId,
            ...$this->map(
                $data,
                fn (array $item): Api\Data\V1\TradeHistoryItem => $this->parseTradeHistoryItem($item)
            )->toArray()
        );
    }

    /**
     * @template TInput
     * @template TOutput
     *
     * @param list<TInput> $data
     * @param \Closure(TInput $arg, string|int $key): TOutput $mapper
     *
     * @return ArrayCollection<int, TOutput>
     */
    private function map(array $data, \Closure $mapper): ArrayCollection
    {
        return new ArrayCollection(array_map($mapper, $data, array_keys($data)));
    }
}
