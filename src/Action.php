<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

/**
 * @psalm-type MarketInfoV1Data = array{
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
interface Action
{
    public const MARKETS = 'markets';
}
