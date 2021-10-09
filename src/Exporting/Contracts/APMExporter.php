<?php

namespace Napopravku\LaravelAPM\Exporting\Contracts;

use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsData;

interface APMExporter
{
    public function export(APMStatisticsData $statisticsData, ScriptInfo $scriptInfo): void;
}
