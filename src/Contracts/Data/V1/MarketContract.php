<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\Data\PairContract;

interface MarketContract extends PairContract
{
    public function getStock(): string;

    public function getMoney(): string;
}
