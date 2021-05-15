<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data;

use JetBrains\PhpStorm\Immutable;
use Kartavik\WhiteBIT\Api\Contracts\Data\PairContract;

use function strtoupper;

#[Immutable]
class Pair implements PairContract
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

    public function getMarketName(): string
    {
        return strtoupper("{$this->getStock()}_{$this->getMoney()}");
    }
}
