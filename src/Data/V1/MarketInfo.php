<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\MarketInfoContract;

class MarketInfo implements MarketInfoContract
{
    public function __construct(
        private string $name,
        private AmountContract $moneyPrecision,
        private string $stock,
        private string $money,
        private AmountContract $stockPrecision,
        private AmountContract $feePrecision,
        private AmountContract $minAmount,
        private AmountContract $makerFee,
        private AmountContract $takerFee
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMoneyPrecision(): AmountContract
    {
        return $this->moneyPrecision;
    }

    public function getStock(): string
    {
        return $this->stock;
    }

    public function getMoney(): string
    {
        return $this->money;
    }

    public function getStockPrecision(): AmountContract
    {
        return $this->stockPrecision;
    }

    public function getFeePrecision(): AmountContract
    {
        return $this->feePrecision;
    }

    public function getMinAmount(): AmountContract
    {
        return $this->minAmount;
    }

    public function getMakerFee(): AmountContract
    {
        return $this->makerFee;
    }

    public function getTakerFee(): AmountContract
    {
        return $this->takerFee;
    }
}
