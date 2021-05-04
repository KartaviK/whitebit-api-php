<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Adapter\Exception;

use Http\Client\Exception;

final class UnexpectedValueException extends \UnexpectedValueException implements Exception
{
}
