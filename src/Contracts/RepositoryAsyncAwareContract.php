<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Http\Promise\Promise;

interface RepositoryAsyncAwareContract
{
    public function getMarketsInfoV1Async(): Promise;
}
