<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

interface RepositoryContract
{
    public function getMarketsInfoV1(): mixed;
}
