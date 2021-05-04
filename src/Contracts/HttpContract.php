<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api\Contracts;

use Http\Promise\Promise;

interface HttpContract
{
    public const BASE_URI = 'https://whitebit.com/api';

    public const VERSION_1 = 'v1';

    public const PUBLIC_API = 'public';

    public function get(string $version, string $type, string $api, array $params = [], array $headers = []): Promise;
}
