<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\TradeHistoryItemContract;

class TradeHistoryItem implements TradeHistoryItemContract
{
    public function __construct(
        private int $id,
        private string $type,
        private float $time,
        private AmountContract $amount,
        private AmountContract $price
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTime(): float
    {
        return $this->time;
    }

    public function getAmount(): AmountContract
    {
        return $this->amount;
    }

    public function getPrice(): AmountContract
    {
        return $this->price;
    }
}
