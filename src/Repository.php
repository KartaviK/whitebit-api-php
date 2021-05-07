<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Http\Promise\Promise;

/**
 * @psalm-import-type MarketInfoV1Data from Action
 */
class Repository implements Contracts\RepositoryContract, Contracts\RepositoryAsyncAwareContract
{
    public function __construct(
        private Contracts\HttpContract $http,
        private ?Contracts\ParserContract $parser = null
    ) {
    }

    public function getMarketsInfo(Version $version): mixed
    {
        return match ($version) {
            Version::V_1() => $this->getMarketsInfoV1(),
            default => throw new Exceptions\UnprocessableVersionException(Action::MARKETS, $version),
        };
    }

    public function getMarketsInfoV1(): mixed
    {
        return $this->getMarketsInfoV1Async()->wait();
    }

    public function getMarketsInfoV1Async(): Promise
    {
        return $this->http->get(Contracts\HttpContract::VERSION_1, Contracts\HttpContract::PUBLIC_API, Action::MARKETS)
            ->then(
                /** @param list<MarketInfoV1Data> $result */
                fn (array $result): array => $this->parse(
                    $result,
                    /** @param list<MarketInfoV1Data> $data */
                    static fn (
                        Contracts\ParserContract $parser,
                        array $data
                    ): array => $parser->parseMarketInfoV1Collection($data)
                )
            );
    }

    /**
     * @template TInput of array
     * @template TOutput
     *
     * @param TInput $data
     * @param \Closure(Contracts\ParserContract $parser, TInput $data): TOutput $parse
     */
    public function parse(array $data, \Closure $parse): mixed
    {
        return $this->parser !== null
            ? $parse($this->parser, $data)
            : $data;
    }
}
