<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use Kartavik\WhiteBIT\Api\Contracts\AmountContract;

class AmountFactory implements Contracts\AmountFactoryContract
{
    public function build(string $value): AmountContract
    {
        return new Data\Amount($value);
    }
}
