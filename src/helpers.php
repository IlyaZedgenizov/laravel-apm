<?php

use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;

if (!function_exists('apm')) {
    function apm(): APMSnapshotCollector
    {
        return app(APMSnapshotCollector::class);
    }
}

if (!function_exists('getRelativeFilePath')) {
    /**
     * @param string[] $parts
     *
     * @return string
     */
    function getRelativeFilePath(array $parts): string
    {
        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}
