<?php

namespace Napopravku\LaravelAPM\Exporting\SimpleFactories;

use Napopravku\LaravelAPM\Exporting\Data\CsvReportRow;
use Napopravku\LaravelAPM\Formatting\DateFormatter;
use Napopravku\LaravelAPM\Formatting\MemoryFormatter;
use Napopravku\LaravelAPM\Formatting\TimeFormatter;
use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsData;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;

class CsvReportRowFactory
{
    public function fromStatisticsAndScriptInfo(APMStatisticsData $statisticsData, ScriptInfo $scriptInfo): CsvReportRow
    {
        $row = new CsvReportRow();

        $row->pid         = $scriptInfo->pid;
        $row->taskType    = TaskTypes::DESCRIPTIONS[$scriptInfo->taskType];
        $row->taskName    = $scriptInfo->taskName;
        $row->execTimeFmt = TimeFormatter::format((int)$statisticsData->executionTime);
        $row->peakMem     = $statisticsData->peakMemory;
        $row->peakMemFmt  = MemoryFormatter::format($statisticsData->peakMemory);
        $row->startedAt   = DateFormatter::format($statisticsData->startedAtTimestamp);
        $row->finishedAt  = DateFormatter::format(
            $statisticsData->startedAtTimestamp + $statisticsData->executionTime
        );

        return $row;
    }
}
