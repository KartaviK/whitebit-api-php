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
use Kartavik\WhiteBIT\Api\Version;

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

        $result = $this->repository->getMarketsInfo(Version::V_1());

        $this->assertCount(1, $result);
        $this->assertArrayHasKey(0, $result);
        $this->assertInstanceOf(V1\MarketInfo::class, $result[0]);
    }

    public function testActivityV1(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => [
                'BTC_USDT' => [
                    'at' => 1594232194,
                    'ticker' => [
                        "bid" => "9412.1",
                        "ask" => "9416.33",
                        "low" => "9203.13",
                        "high" => "9469.99",
                        "last" => "9414.4",
                        "vol" => "27324.819448",
                        "deal" => "254587570.43407191",
                        "change" => "1.53"
                    ],
                ],
            ],
        ])));

        $result = $this->repository->getMarketsActivityV1();

        $this->assertCount(1, $result);
        $this->assertArrayHasKey(0, $result);
        $this->assertInstanceOf(V1\MarketActivity::class, $result[0]);
    }

    public function testGetSingleMarketActivity(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => [
                "bid" => "9412.1",
                "ask" => "9416.33",
                "low" => "9203.13",
                "high" => "9469.99",
                "last" => "9414.4",
                "volume" => "27324.819448",
                "deal" => "254587570.43407191",
                "change" => "1.53",
            ],
        ])));

        $result = $this->repository->getSingleMarketActivityV1('ETH', 'BTC');

        $this->assertInstanceOf(V1\MarketActivity::class, $result);
    }

    public function testGetkline(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => [
                [
                    594166400,
                    "9257.4",
                    "9243.19",
                    "9265.14",
                    "9231.32",
                    "817.535991",
                    "7558389.54233595",
                ],
            ],
        ])));

        $result = $this->repository->getKline('ETH', 'BTC');

        $this->assertInstanceOf(V1\KlineCollection::class, $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(V1\Kline::class, $result[0]);
    }
}
