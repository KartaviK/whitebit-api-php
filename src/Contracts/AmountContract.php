<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

interface AmountContract
{
    /** @return numeric-string */
    public function getValue(): string;
}
