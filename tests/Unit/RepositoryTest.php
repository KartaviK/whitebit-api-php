<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Tests\Unit;

use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp;
use Kartavik\WhiteBIT\Api\Adapter\Client;
use Kartavik\WhiteBIT\Api\AmountFactory;
use Kartavik\WhiteBIT\Api\Contracts\Data\V1\TradeHistoryItemContract;
use Kartavik\WhiteBIT\Api\Data\Pair;
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
    private Repository $objectableRepository;
    private Repository $pureRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $client = new GuzzleHttp\Client([
            'handler' => $this->stack,
        ]);
        $this->http = new Http(new Client($client), new RequestFactory());
        $this->objectableRepository = new Repository($this->http, new Parser(new AmountFactory()));
        $this->pureRepository = new Repository($this->http);
    }

    public function testMarketsV1(): void
    {
        $item = [
            'name' => 'BTC_USDT',
            'moneyPrec' => '1',
            'stock' => 'BTC',
            'money' => 'USDT',
            'stockPrec' => '2',
            'feePrec' => '3',
            'minAmount' => '12',
            'makerFee' => '0.002',
            'takerFee' => '0.223',
        ];
        $result = [
            $item,
            $item,
        ];
        $response = new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => $result,
        ]));
        $this->mock->append(
            $response,
            $response
        );

        /** @var ArrayCollection<int, V1\MarketInfo> $objectResult */
        $objectResult = $this->objectableRepository->getMarketsInfo(Version::V_1());

        $this->assertCount(2, $objectResult);
        $this->assertArrayHasKey(0, $objectResult);
        $this->assertArrayHasKey(1, $objectResult);
        $this->assertInstanceOf(V1\MarketInfo::class, $objectResult[0]);

        $pureResult = $this->pureRepository->getMarketsInfoV1();

        $this->assertEquals($result, $pureResult);
    }

    public function testActivityV1(): void
    {
        $item = [
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
        ];
        $result = [
            'BTC_USDT' => $item,
            'BTC_ETH' => $item,
        ];
        $response = new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => $result,
        ]));
        $this->mock->append(
            $response,
            $response
        );

        /** @var ArrayCollection<int, V1\MarketActivity> $objectResult */
        $objectResult = $this->objectableRepository->getMarketsActivityV1();

        $this->assertCount(2, $objectResult);
        $this->assertArrayHasKey(0, $objectResult);
        $this->assertArrayHasKey(1, $objectResult);
        $this->assertInstanceOf(V1\MarketActivity::class, $objectResult[0]);

        $pureResult = $this->pureRepository->getMarketsActivityV1();

        $this->assertEquals($result, $pureResult);
    }

    public function testGetSingleMarketActivity(): void
    {
        $result = [
            "bid" => "9412.1",
            "ask" => "9416.33",
            "low" => "9203.13",
            "high" => "9469.99",
            "last" => "9414.4",
            "volume" => "27324.819448",
            "deal" => "254587570.43407191",
            "change" => "1.53",
        ];
        $response = new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => $result,
        ]));
        $this->mock->append(
            $response,
            $response
        );

        $stock = 'ETH';
        $money = 'BTC';
        $pair = new Pair($stock, $money);
        $objectResult = $this->objectableRepository->getSingleMarketActivityV1($pair);

        $this->assertInstanceOf(V1\MarketActivity::class, $objectResult);

        $pureResult = $this->pureRepository->getSingleMarketActivityV1($pair);

        $this->assertEquals($result, $pureResult);
    }

    public function testGetkline(): void
    {
        $item = [
            594166400,
            "9257.4",
            "9243.19",
            "9265.14",
            "9231.32",
            "817.535991",
            "7558389.54233595",
        ];
        $result = [
            $item,
            $item,
        ];
        $response = new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => $result,
        ]));
        $this->mock->append(
            $response,
            $response
        );

        $stock = 'ETH';
        $money = 'BTC';
        $pair = new Pair($stock, $money);
        /** @var V1\KlineCollection $objectResult */
        $objectResult = $this->objectableRepository->getKline($pair);

        $this->assertInstanceOf(V1\KlineCollection::class, $objectResult);
        $this->assertEquals($pair->getMarketName(), $objectResult->getMarket());
        $this->assertCount(2, $objectResult);
        $this->assertArrayHasKey(0, $objectResult);
        $this->assertArrayHasKey(1, $objectResult);
        $this->assertInstanceOf(V1\Kline::class, $objectResult[0]);

        $pureResult = $this->pureRepository->getKline($pair);

        $this->assertEquals($result, $pureResult);
    }

    public function testGetSymbols(): void
    {
        $result = [
            'BTC_USDT',
            'BTC_ETH',
        ];
        $response = new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => $result,
        ]));
        $this->mock->append(
            $response,
            $response
        );

        $objectResult = $this->objectableRepository->getSymbolsV1();

        $this->assertCount(2, $objectResult);
        $this->assertInstanceOf(V1\Market::class, $objectResult[0]);

        $pureResult = $this->pureRepository->getSymbolsV1();

        $this->assertEquals($result, $pureResult);
    }

    public function testGetHistory(): void
    {
        $item = [
            'id' => 1231231,
            'type' => TradeHistoryItemContract::TYPE_BUY,
            'time' => 123123.123123,
            'amount' => '123123.312313',
            'price' => '123123.123123',
        ];
        $result = [
            $item,
            $item,
        ];
        $response = new GuzzleHttp\Psr7\Response(200, [], \Safe\json_encode([
            'success' => true,
            'message' => '',
            'result' => $result,
        ]));
        $this->mock->append(
            $response,
            $response
        );

        $lastId = 123;
        $stock = 'BTC';
        $money = 'ETH';
        $pair = new Pair($stock, $money);
        /** @var V1\TradeHistoryCollection $objectResult */
        $objectResult = $this->objectableRepository->getTradeHistoryV1($pair, $lastId);

        $this->assertCount(2, $objectResult);
        $this->assertArrayHasKey(0, $objectResult);
        $this->assertArrayHasKey(1, $objectResult);
        $this->assertEquals($pair->getMarketName(), $objectResult->getMarket());
        $this->assertInstanceOf(TradeHistoryItemContract::class, $objectResult[0]);
        $this->assertEquals($lastId, $objectResult->getLastId());

        $pureResult = $this->pureRepository->getTradeHistoryV1($pair, $lastId);

        $this->assertEquals($result, $pureResult);
    }
}
