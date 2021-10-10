<?php

namespace Napopravku\LaravelAPM\Statistics\Events;

use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsData;

class StatisticsCollected
{
    private APMStatisticsData $statisticsData;

    private ScriptInfo $scriptInfo;

    public function __construct(APMStatisticsData $statisticsData, ScriptInfo $scriptInfo)
    {
        $this->statisticsData = $statisticsData;
        $this->scriptInfo     = $scriptInfo;
    }

    /**
     * @return APMStatisticsData
     */
    public function getStatisticsData(): APMStatisticsData
    {
        return $this->statisticsData;
    }

    /**
     * @return ScriptInfo
     */
    public function getScriptInfo(): ScriptInfo
    {
        return $this->scriptInfo;
    }
}
