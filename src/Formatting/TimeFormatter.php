<?php

namespace Napopravku\LaravelAPM\Formatting;

use DateTime;

class TimeFormatter
{
    public static function format(int $seconds): string
    {
        $format = config('apm.formats.time');

        $dtF = new DateTime('@0');
        $dtT = new DateTime("@{$seconds}");

        return $dtF->diff($dtT)->format($format);
    }
}
