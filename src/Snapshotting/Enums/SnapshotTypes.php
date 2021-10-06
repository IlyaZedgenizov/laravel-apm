<?php

namespace Napopravku\LaravelAPM\Snapshotting\Enums;

class SnapshotTypes
{
    public const TIME = 1;

    public const PEAK_MEMORY = 2;

    // Not implemented yet
    public const CPU = 3;

    // Not implemented yet
    public const DB_QUERY_TIME = 4;

    public static function isPeakMemory(int $snapshotType): bool
    {
        return $snapshotType === self::PEAK_MEMORY;
    }
}
