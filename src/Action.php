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
 * @psalm-type MarketActivity = array{
 *  bid: numeric-string,
 *  ask: numeric-string,
 *  low: numeric-string,
 *  high: numeric-string,
 *  last: numeric-string,
 *  vol: numeric-string,
 *  deal: numeric-string,
 *  change: numeric-string
 * }
 * @psalm-type MarketActivityV1Data = array{
 *  at: int,
 *  ticker: MarketActivity
 * }
 * @psalm-type KlineItem = array{
 *  0: int,
 *  1: numeric-string,
 *  3: numeric-string,
 *  4: numeric-string,
 *  5: numeric-string,
 *  6: numeric-string
 * }
 * @psalm-type TradeHistoryItem = array{
 *  id: int,
 *  type: 'buy'|'sell',
 *  time: float,
 *  amount: numeric-string,
 *  price: numeric-string
 * }
 */
interface Action
{
    public const MARKETS = 'markets';
    public const TICKERS = 'tickers';
    public const TICKER = 'ticker';
    public const KLINE = 'kline';
    public const SYMBOLS = 'symbols';
    public const HISTORY = 'history';
}
