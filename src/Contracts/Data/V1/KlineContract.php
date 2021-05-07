<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;

interface KlineContract
{
    public function getTime(): int;

    public function getOpen(): AmountContract;

    public function getClose(): AmountContract;

    public function getHigh(): AmountContract;

    public function getLow(): AmountContract;

    public function getVolumeStock(): AmountContract;

    public function getVolumeMoney(): AmountContract;
}
