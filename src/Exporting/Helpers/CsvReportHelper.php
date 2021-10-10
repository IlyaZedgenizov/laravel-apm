<?php

namespace Napopravku\LaravelAPM\Exporting\Helpers;

class CsvReportHelper
{
    public const DATE_FILENAME_SEPARATOR = '--';

    public const DIR = 'apm' . DIRECTORY_SEPARATOR . 'csv';

    public const PARTS_DIR = self::DIR . DIRECTORY_SEPARATOR . 'tmp';

    private const FILENAME = 'apm';

    public static function buildReportPath(string $date): string
    {
        return getRelativeFilePath([
            self::DIR,
            $date . self::DATE_FILENAME_SEPARATOR . self::FILENAME . '.csv'
        ]);
    }

    public static function buildReportPartPath(string $date, int $pid): string
    {
        $filename = self::FILENAME;

        return getRelativeFilePath([
            self::buildReportPartsDirPathByDate($date),
            $pid,
            "$filename.csv"
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
