<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Doctrine\Common\Collections\ArrayCollection;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\TradeHistoryItemContract;

/**
 * @template-extends ArrayCollection<int, TradeHistoryItemContract>
 */
class TradeHistoryCollection extends ArrayCollection
{
    public function __construct(
        private string $market,
        TradeHistoryItemContract ...$history
    ) {
        parent::__construct($history);
    }

    public function getMarket(): string
    {
        return $this->market;
    }
}
