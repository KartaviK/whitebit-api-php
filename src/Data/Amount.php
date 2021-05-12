<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Data;

use Kartavik\WhiteBIT\Api\Contracts;

use function is_numeric;

class Amount implements Contracts\AmountContract
{
    /** @var numeric-string */
    private string $value;

    /** @param numeric-string $value */
    public function __construct(string $value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("Value [{$value}] is not numeric!");
        }

        $this->value = $value;
    }

    /** {@inheritdoc} */
    public function getValue(): string
    {
        return $this->value;
    }
}
