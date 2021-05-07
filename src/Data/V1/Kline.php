<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\KlineContract;

class Kline implements KlineContract
{
    public function __construct(
        private int $time,
        private AmountContract $open,
        private AmountContract $close,
        private AmountContract $high,
        private AmountContract $low,
        private AmountContract $volumeStock,
        private AmountContract $volumeMoney
    ) {
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getOpen(): AmountContract
    {
        return $this->open;
    }

    public function getClose(): AmountContract
    {
        return $this->close;
    }

    public function getHigh(): AmountContract
    {
        return $this->high;
    }

    public function getLow(): AmountContract
    {
        return $this->low;
    }

    public function getVolumeStock(): AmountContract
    {
        return $this->volumeStock;
    }

    public function getVolumeMoney(): AmountContract
    {
        return $this->volumeMoney;
    }
}
