<?php

namespace Napopravku\LaravelAPM\Exporting\Data;

class CsvReportStorageOptions
{
    public bool $enableConcurrentSafety;

    public int $pid;

    public static function create(int $pid, bool $enableConcurrentSafety): self
    {
        $instance = new static();

        $instance->pid = $pid;
        $instance->enableConcurrentSafety = $enableConcurrentSafety;

        return $instance;
    }
}
