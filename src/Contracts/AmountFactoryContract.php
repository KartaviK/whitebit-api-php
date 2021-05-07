<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

interface AmountFactoryContract
{
    /** @param numeric-string $amount */
    public function build(string $amount): AmountContract;
}
