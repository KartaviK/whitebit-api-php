<?php

declare(strict_types=1);

namespace Kartavik\WhiteBIT\Api;

interface Interval
{
    public const DEFAULT = '1h';

    public const MINUTES_1 = '1m';
    public const MINUTES_3 = '3m';
    public const MINUTES_5 = '5m';
    public const MINUTES_15 = '15m';
    public const MINUTES_30 = '30m';
    public const HOURS_1 = '1h';
    public const HOURS_2 = '2h';
    public const HOURS_4 = '4h';
    public const HOURS_6 = '6h';
    public const HOURS_8 = '8h';
    public const HOURS_12 = '12h';
    public const DAYS_1 = '1d';
    public const DAYS_3 = '3d';
    public const WEEKS_1 = '1w';
    public const MONTHS_1 = '1M';
}
