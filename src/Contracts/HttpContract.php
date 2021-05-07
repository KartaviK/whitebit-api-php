<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Http\Promise\Promise;
use Kartavik\WhiteBIT\Api\Version;

interface HttpContract
{
    public const BASE_URI = 'https://whitebit.com/api';

    public const PUBLIC_API = 'public';

    /**
     * @param array<string, string|int|float> $params
     * @param array<string, string>           $headers
     */
    public function get(Version $version, string $type, string $api, array $params = [], array $headers = []): Promise;
}
