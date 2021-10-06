<?php

use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;

if (!function_exists('apm')) {
    function apm(): APMSnapshotCollector
    {
        return app(APMSnapshotCollector::class);
    }
}
