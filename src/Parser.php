<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Kartavik\WhiteBIT\Api\Contracts\AmountFactoryContract;
use Kartavik\WhiteBIT\Api\Contracts\ParserContract;

/**
 * @psalm-import-type MarketInfoV1Data from Action
 */
class Parser implements ParserContract
{
    public function __construct(private AmountFactoryContract $amountFactory) {}

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

    public function parseMarketInfoV1Collection(array $data): array
    {
        return $this->map($data, fn (array $arg): Data\V1\MarketInfo => $this->parseMarketInfoV1($arg));
    }

    /**
     * @template TInput
     * @template TOutput
     *
     * @param list<TInput>                   $data
     * @param \Closure(TInput $arg): TOutput $mapper
     *
     * @return list<TOutput>
     */
    private function map(array $data, \Closure $mapper): array
    {
        $result = [];

        foreach ($data as $datum) {
            $result[] = $mapper($datum);
        }

        return $result;
    }
}
