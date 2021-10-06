<?php

namespace Napopravku\LaravelAPM\Statistics\Collectors;

use Illuminate\Support\Arr;
use Napopravku\LaravelAPM\Snapshotting\Data\SnapshotsCollection;
use Napopravku\LaravelAPM\Statistics\Contracts\StatisticsCollector;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;

class SummaryStatisticsCollector implements StatisticsCollector
{
    public function collect(SnapshotsCollection $snapshotsCollection): SummaryStatisticsData
    {
        $start = (int)Arr::first($snapshotsCollection->getTimeSnapshots());
        $end   = (int)Arr::last($snapshotsCollection->getTimeSnapshots());

        $maxPeakMemory = max(
            array_column($snapshotsCollection->getPeakMemorySnapshots(), 'bytes')
        );

        return SummaryStatisticsData::create($end - $start, $start, $maxPeakMemory);
    }
}
