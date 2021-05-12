<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Kartavik\WhiteBIT\Api\Contracts\Data\V1\MarketContract;

class Market implements MarketContract
{
    public function __construct(
        private string $stock,
        private string $money
    ) {
    }

    public function getStock(): string
    {
        return $this->stock;
    }

    public function getMoney(): string
    {
        return $this->money;
    }
}
