<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Doctrine\Common\Collections\ArrayCollection;
use Kartavik\WhiteBIT\Api;
use Kartavik\WhiteBIT\Api\Contracts\AmountFactoryContract;

/**
 * @psalm-import-type MarketInfoV1Data from Action
 * @psalm-import-type MarketActivityV1Data from Action
 */
class Parser implements Api\Contracts\ParserContract
{
    public function __construct(private AmountFactoryContract $amountFactory) {}

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
    public function parseMarketActivityV1(string $name, array $data): Api\Contracts\Data\V1\MarketActivityContract
    {
        $ticker = $data['ticker'];

        return new Api\Data\V1\MarketActivity(
            $name,
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
            fn (array $arg, string $name): Api\Data\V1\MarketActivity => $this->parseMarketActivityV1($name, $arg)
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
