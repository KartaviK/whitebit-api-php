<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Doctrine\Common\Collections\ArrayCollection;
use Kartavik\WhiteBIT\Api\Contracts\Data\PairContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\KlineCollectionContract;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\KlineContract;

/**
 * @template-extends ArrayCollection<int, KlineContract>
 */
class KlineCollection extends ArrayCollection implements KlineCollectionContract
{
    public function __construct(
        private PairContract $pair,
        KlineContract ...$kline
    ) {
        parent::__construct($kline);
    }

    public function getMarket(): string
    {
        return $this->pair->getMarketName();
    }

    public function getKline(): array
    {
        return $this->toArray();
    }
}
