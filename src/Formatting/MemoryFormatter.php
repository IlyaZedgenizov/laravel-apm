<?php

namespace Napopravku\LaravelAPM\Formatting;

class MemoryFormatter
{
    public static function format(int $bytes): string
    {
        $units = ['b', 'kb', 'mb', 'gb'];
        $i     = (int)floor(log($bytes, 1024));

        return @round($bytes / (1024 ** $i), 2) . ' ' . $units[$i];
    }
}
