<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * @template T of array|object
 *
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
    /** @return T */
    public function parse(ResponseInterface $response): mixed;

    /**
     * @template TOutput of T
     *
     * @param MarketInfoArrayData $data
     *
     * @return TOutput
     */
    public function parseMarketInfoV1(array $data): mixed;

    /**
     * @template TOutput of T
     *
     * @return list<TOutput>
     */
    public function parseMarketInfoV1Collection(ResponseInterface $response): mixed;
}
