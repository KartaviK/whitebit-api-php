<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

/**
 * @psalm-type MarketInfoArrayData = array{
 *  name: string,
 *  moneyPrec: numeric-string,
 *  stock: string,
 *  money: string,
 *  stockPrec: numeric-string,
 *  feePrec: numeric-string,
 *  minAmount: numeric-string,
 *  makerFee: numeric-string,
 *  takerFee: numeric-string
 * }
 */
interface ParserContract
{
    /**
     * @param MarketInfoArrayData $data
     *
     * @template T
     *
     * @return T
     */
    public function parseMarketInfoV1(array $data): mixed;

    /**
     * @param list<MarketInfoArrayData> $data
     *
     * @template T
     *
     * @return T
     */
    public function parseMarketInfoV1Collection(array $data): mixed;
}
