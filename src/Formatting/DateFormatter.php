<?php

namespace Napopravku\LaravelAPM\Formatting;

use Illuminate\Support\Carbon;

class DateFormatter
{
    public static function format(int $timestamp): string
    {
        $format   = config('apm.formats.date');
        $timezone = config('apm.timezone');

        return Carbon
            ::createFromTimestamp($timestamp)
            ->timezone($timezone)
            ->format($format);
    }
}
