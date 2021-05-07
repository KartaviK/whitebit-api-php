<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Doctrine\Common\Collections\Collection;
use Kartavik\WhiteBIT\Api;

/**
 * @psalm-import-type MarketInfoV1Data from Api\Action
 * @psalm-import-type MarketActivityV1Data from Api\Action
 */
interface ParserContract
{
    /**
     * @param MarketInfoV1Data $data
     */
    public function parseMarketInfoV1(array $data): Api\Contracts\Data\V1\MarketInfoContract;

    /**
     * @param list<MarketInfoV1Data> $data
     *
     * @return Collection<int, Api\Contracts\Data\V1\MarketInfoContract>
     */
    public function parseMarketInfoV1Collection(array $data): Collection;

    /**
     * @param MarketActivityV1Data $data
     */
    public function parseMarketActivityV1(string $name, array $data): Api\Contracts\Data\V1\MarketActivityContract;

    /**
     * @param array<string, MarketActivityV1Data> $data
     * @return Collection<int, Api\Contracts\Data\V1\MarketActivityContract>
     */
    public function parseMarketActivityV1Collection(array $data): Collection;
}
