<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;

interface MarketInfoContract
{
    public function getName(): string;

    public function getMoneyPrecision(): AmountContract;

    public function getStock(): string;

    public function getMoney(): string;

    public function getStockPrecision(): AmountContract;

    public function getFeePrecision(): AmountContract;

    public function getMinAmount(): AmountContract;

    public function getMakerFee(): AmountContract;

    public function getTakerFee(): AmountContract;
}
