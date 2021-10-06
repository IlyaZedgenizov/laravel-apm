<?php

namespace Napopravku\LaravelAPM\Exporting\Contracts;

use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\StatisticsData;

interface APMExporter
{
    public function export(StatisticsData $statisticsData, ScriptInfo $scriptInfo): void;
}
