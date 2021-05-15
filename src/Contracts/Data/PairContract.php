<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data;

interface PairContract
{
    public function getMarketName(): string;
}
