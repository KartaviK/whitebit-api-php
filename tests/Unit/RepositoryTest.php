<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Tests\Unit;

use Kartavik\WhiteBIT\Api\Adapter\Client;
use Kartavik\WhiteBIT\Api\AmountFactory;
use Kartavik\WhiteBIT\Api\Http;
use Kartavik\WhiteBIT\Api\Parser\ArrayParser;
use Kartavik\WhiteBIT\Api\Parser\ObjectParser;
use Kartavik\WhiteBIT\Api\Repository;
use Kartavik\WhiteBIT\Api\Tests\RequestFactory;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    public function testMarketsV1(): void
    {
        $http = new Http(new Client(), new RequestFactory());

        $repo = new Repository($http, new ObjectParser(new AmountFactory(), new ArrayParser()));

        $result = $repo->getMarketsInfoV1Async()->wait();

        dd($result);
    }
}
