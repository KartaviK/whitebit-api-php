<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data\V1;

interface MarketContract
{
    public function getStock(): string;

    public function getMoney(): string;
}
