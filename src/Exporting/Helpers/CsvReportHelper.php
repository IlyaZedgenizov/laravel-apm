<?php

namespace Napopravku\LaravelAPM\Exporting\Helpers;

class CsvReportHelper
{
    public const DIR = 'apm' . DIRECTORY_SEPARATOR . 'csv';

    public const PARTS_DIR = self::DIR . DIRECTORY_SEPARATOR . 'tmp';

    public const FILENAME_DATE_FORMAT = 'Y-m-d';

    public static function buildReportPath(string $date): string
    {
        return getRelativeFilePath([
            self::DIR,
            "$date.csv"
        ]);
    }

    public static function buildReportPartPath(string $date, int $pid): string
    {
        return getRelativeFilePath([
            self::buildReportPartsDirPathByDate($date),
            $pid,
            "apm-tmp-part.csv"
        ]);
    }

    public static function buildReportPartsDirPathByDate(string $date): string
    {
        return getRelativeFilePath([
            self::PARTS_DIR,
            $date,
        ]);
    }
}
