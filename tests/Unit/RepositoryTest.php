<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Tests\Unit;

use GuzzleHttp;
use Kartavik\WhiteBIT\Api\Adapter\Client;
use Kartavik\WhiteBIT\Api\AmountFactory;
use Kartavik\WhiteBIT\Api\Data\V1;
use Kartavik\WhiteBIT\Api\Http;
use Kartavik\WhiteBIT\Api\Parser;
use Kartavik\WhiteBIT\Api\Repository;
use Kartavik\WhiteBIT\Api\Tests\RequestFactory;
use Kartavik\WhiteBIT\Api\Tests\TestCase;

class RepositoryTest extends TestCase
{
    private Http $http;
    private Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();


        $client = new GuzzleHttp\Client([
            'handler' => $this->stack,
        ]);
        $this->http = new Http(new Client($client), new RequestFactory());
        $this->repository = new Repository($this->http, new Parser(new AmountFactory()));
    }

    public function testMarketsV1(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => [
                [
                    'name' => 'BTC_USDT',
                    'moneyPrec' => '1',
                    'stock' => 'BTC',
                    'money' => 'USDT',
                    'stockPrec' => '2',
                    'feePrec' => '3',
                    'minAmount' => '12',
                    'makerFee' => '0.002',
                    'takerFee' => '0.223',
                ],
            ],
        ])));

        $result = $this->repository->getMarketsInfoV1();

        $this->assertCount(1, $result);
        $this->assertArrayHasKey(0, $result);
        $this->assertInstanceOf(V1\MarketInfo::class, $result[0]);
    }
}
