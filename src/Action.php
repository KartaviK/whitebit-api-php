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
 *
 * @psalm-type MarketActivityV1Data = array{
 *  at: int,
 *  ticker: array{
 *  bid: numeric-string,
 *  ask: numeric-string,
 *  low: numeric-string,
 *  high: numeric-string,
 *  last: numeric-string,
 *  vol: numeric-string,
 *  deal: numeric-string,
 *  change: numeric-string
 * }
 */
interface Action
{
    public const MARKETS = 'markets';
    public const TICKERS = 'tickers';
}
