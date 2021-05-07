<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Kartavik\WhiteBIT\Api;

/**
 * @psalm-import-type MarketInfoV1Data from Api\Action
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
     * @return list<Api\Contracts\Data\V1\MarketInfoContract>
     */
    public function parseMarketInfoV1Collection(array $data): mixed;
}
