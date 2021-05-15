<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts\Data\V1;

interface KlineCollectionContract
{
    public function getMarket(): string;

    /** @return list<KlineContract> */
    public function getKline(): array;
}
