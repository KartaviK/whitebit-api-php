<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

interface AmountFactoryContract
{
    public function build(string $value): AmountContract;
}
