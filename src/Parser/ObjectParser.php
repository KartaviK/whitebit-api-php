<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Parser;

use Kartavik\WhiteBIT\Api\Contracts\AmountFactoryContract;
use Kartavik\WhiteBIT\Api\Contracts\ParserContract;
use Kartavik\WhiteBIT\Api\Data;
use Psr\Http\Message\ResponseInterface;

/**
 * @template-implements ParserContract<object>
 *
 * @psalm-import-type MarketInfoArrayData from ParserContract
 */
class ObjectParser implements ParserContract
{
    public function __construct(
        private AmountFactoryContract $amountFactory,
        private ArrayParser $parser
    ){
    }

    public function parse(ResponseInterface $response): array
    {
        return $this->parser->parse($response);
    }

    public function parseMarketInfoV1(array $data): Data\V1\MarketInfo
    {
        return new Data\V1\MarketInfo(
            $data['name'],
            $this->amountFactory->build($data['moneyPrec']),
            $data['stock'],
            $data['money'],
            $this->amountFactory->build($data['stockPrec']),
            $this->amountFactory->build($data['feePrec']),
            $this->amountFactory->build($data['minAmount']),
            $this->amountFactory->build($data['makerFee']),
            $this->amountFactory->build($data['takerFee'])
        );
    }

    public function parseMarketInfoV1Collection(ResponseInterface $response): array
    {
        $data = $this->parser->parse($response);
        $result = $data['success']
            ? $this->map(
                $data['result'],
                fn ($arg): Data\V1\MarketInfo => $this->parseMarketInfoV1($arg)
            )
            : [];
        $data['result'] = $result;

        return $data;
    }

    /**
     * @template TInput
     * @template TOutput
     *
     * @param list<TInput>                   $data
     * @param \Closure(TInput $arg): TOutput $mapper
     *
     * @return list<TOutput>
     */
    private function map(array $data, \Closure $mapper): array
    {
        $result = [];

        foreach ($data as $datum) {
            $result[] = $mapper($datum);
        }

        return $result;
    }
}
