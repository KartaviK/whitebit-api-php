<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

use MyCLabs\Enum\Enum;

/**
 * @method static self V_1()
 * @method static self V_2()
 * @method static self V_3()
 * @template-extends Enum<string>
 * @psalm-immutable
 */
final class Version extends Enum
{
    public const V_1 = 'v1';
    public const V_2 = 'v2';
    public const V_4 = 'v4';
}
