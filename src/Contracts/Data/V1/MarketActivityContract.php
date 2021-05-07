<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;

interface MarketActivityContract
{
    public function getName(): string;

    public function getTime(): int;

    public function getBid(): AmountContract;

    public function getAsk(): AmountContract;

    public function getLow(): AmountContract;

    public function getHigh(): AmountContract;

    public function getLast(): AmountContract;

    public function getVol(): AmountContract;

    public function getDeal(): AmountContract;

    public function getChange(): AmountContract;
}
