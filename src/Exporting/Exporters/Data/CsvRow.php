<?php

namespace Napopravku\LaravelAPM\Exporting\Exporters\Data;

use Illuminate\Contracts\Support\Arrayable;

class CsvRow implements Arrayable
{
    public const COLUMN_NAMES = [
        'pid',
        'task_type',
        'task_name',
        'execution_time',
        'peak_memory_bytes',
        'peak_memory_formatted',
        'started_at',
        'finished_at',
    ];

    public int $pid;

    public string $taskType;

    public string $taskName;

    public string $execTimeFmt;

    public int $peakMem;

    public string $peakMemFmt;

    public string $startedAt;

    public string $finishedAt;

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function toRowString(string $separator = ','): string
    {
        return implode($separator, $this->toArray());
    }

    public static function getHeaderRowString(string $separator = ','): string
    {
        return implode($separator, self::COLUMN_NAMES) . PHP_EOL;
    }
}
