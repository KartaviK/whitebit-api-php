<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;

interface TradeHistoryItemContract
{
    public const TYPE_SELL = 'sell';
    public const TYPE_BUY = 'buy';

    public function getId(): int;

    /** @psalm-return self::TYPE_* */
    public function getType(): string;

    public function getTime(): float;

    public function getAmount(): AmountContract;

    public function getPrice(): AmountContract;
}
