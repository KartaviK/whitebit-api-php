<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\MarketActivityContract;

class MarketActivity implements MarketActivityContract
{
    public function __construct(
        private string $name,
        private int $time,
        private AmountContract $bid,
        private AmountContract $ask,
        private AmountContract $low,
        private AmountContract $high,
        private AmountContract $last,
        private AmountContract $vol,
        private AmountContract $deal,
        private AmountContract $change
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getBid(): AmountContract
    {
        return $this->bid;
    }

    public function getAsk(): AmountContract
    {
        return $this->ask;
    }

    public function getLow(): AmountContract
    {
        return $this->low;
    }

    public function getHigh(): AmountContract
    {
        return $this->high;
    }

    public function getLast(): AmountContract
    {
        return $this->last;
    }

    public function getVol(): AmountContract
    {
        return $this->vol;
    }

    public function getDeal(): AmountContract
    {
        return $this->deal;
    }

    public function getChange(): AmountContract
    {
        return $this->change;
    }
}
