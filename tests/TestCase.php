<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected MockHandler $mock;
    protected HandlerStack $stack;
    protected array $container;

    protected function setUp(): void
    {
        $this->mock = new MockHandler();
        $this->container = [];
        $this->stack = HandlerStack::create($this->mock);
        $this->stack->push(Middleware::history($this->container));
    }
}
