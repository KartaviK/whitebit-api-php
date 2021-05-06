<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Parser;

use Kartavik\WhiteBIT\Api\Contracts\ParserContract;
use Psr\Http\Message\ResponseInterface;

use function Safe\json_decode;

/**
 * @template-implements ParserContract<array>
 *
 * @psalm-import-type MarketInfoArrayData from ParserContract
 */
class ArrayParser implements ParserContract
{
    /**
     * @return array{success: bool, message: string, result: mixed[], params?: mixed[]}
     */
    public function parse(ResponseInterface $response): array
    {
        return (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    /** @return MarketInfoArrayData */
    public function parseMarketInfoV1(array $data): array
    {
        return $data;
    }

    /** @return array{success: bool, message: string, result: list<MarketInfoArrayData>, params?: mixed[]} */
    public function parseMarketInfoV1Collection(ResponseInterface $response): array
    {
        return $this->parse($response);
    }
}
