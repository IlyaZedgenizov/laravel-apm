<?php

namespace Napopravku\LaravelAPM\Exporting\Exporters;

use Napopravku\LaravelAPM\Exporting\Contracts\APMExporter;
use Napopravku\LaravelAPM\Exporting\Storage\CsvStorage;
use Napopravku\LaravelAPM\Formatting\DateFormatter;
use Napopravku\LaravelAPM\Formatting\MemoryFormatter;
use Napopravku\LaravelAPM\Formatting\TimeFormatter;
use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\StatisticsData;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;

class CsvExporter implements APMExporter
{
    private CsvStorage $storage;

    public function __construct(CsvStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param SummaryStatisticsData $statisticsData
     * @param ScriptInfo            $scriptInfo
     */
    public function export(StatisticsData $statisticsData, ScriptInfo $scriptInfo): void
    {
        $separator = config('apm.export.csv.separator');

        $data = '';

        if (!$this->storage->exists()) {
            $data = implode($separator, $this->getHeader()) . PHP_EOL;
        }

        $row = $this->getRow($statisticsData, $scriptInfo);

        $data .= implode($separator, $row) . PHP_EOL;

        $this->storage->store($data);
    }

    /**
     * @param SummaryStatisticsData $statisticsData
     * @param ScriptInfo            $scriptInfo
     *
     * @return array
     */
    protected function getRow(StatisticsData $statisticsData, ScriptInfo $scriptInfo): array
    {
        $header = $this->getHeader();

        $row = [];

        foreach ($header as $column) {
            switch ($column) {
                case 'pid':
                    $row[] = $scriptInfo->pid;
                    break;
                case 'task_type':
                    $row[] = $scriptInfo->taskType;
                    break;
                case 'task_name':
                    $row[] = $scriptInfo->taskName;
                    break;
                case 'execution_time':
                    $row[] = TimeFormatter::format($statisticsData->executionTime);
                    break;
                case 'peak_memory_bytes':
                    $row[] = $statisticsData->peakMemory;
                    break;
                case 'peak_memory_formatted':
                    $row[] = MemoryFormatter::format($statisticsData->peakMemory);
                    break;
                case 'started_at':
                    $row[] = DateFormatter::format($statisticsData->startedAtTimestamp);
                    break;
            }
        }

        return $row;
    }

    protected function getHeader(): array
    {
        return [
            'pid',
            'task_type',
            'task_name',
            'execution_time',
            'peak_memory_bytes',
            'peak_memory_formatted',
            'started_at',
        ];
    }
}
