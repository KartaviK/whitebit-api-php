<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data\V1;

use Doctrine\Common\Collections\ArrayCollection;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\KlineCollectionContract;

/**
 * @template-extends ArrayCollection<int, Kline>
 */
class KlineCollection extends ArrayCollection implements KlineCollectionContract
{
    public function __construct(
        private string $name,
        Kline ...$kline
    ) {
        parent::__construct($kline);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getKline(): array
    {
        return $this->toArray();
    }
}
