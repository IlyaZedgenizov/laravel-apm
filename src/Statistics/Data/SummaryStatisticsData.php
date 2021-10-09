<?php

namespace Napopravku\LaravelAPM\Statistics\Data;

use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsData;

class SummaryStatisticsData implements APMStatisticsData
{
    public float $executionTime;

    public float $startedAtTimestamp;

    public int $peakMemory;

    public static function create(float $executionTime, float $startedAtTimestamp, int $maxPeakMemory): self
    {
        $instance = new static();

        $instance->executionTime      = $executionTime;
        $instance->startedAtTimestamp = $startedAtTimestamp;
        $instance->peakMemory         = $maxPeakMemory;

        return $instance;
    }
}
