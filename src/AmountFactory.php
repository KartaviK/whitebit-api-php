<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

class AmountFactory implements Contracts\AmountFactoryContract
{
    /** {@inheritDoc} */
    public function build(string $amount): Data\Amount
    {
        return new Data\Amount($amount);
    }
}
