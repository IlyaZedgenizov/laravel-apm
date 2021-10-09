<?php

namespace Napopravku\LaravelAPM\Statistics\Collectors;

use Illuminate\Support\Arr;
use Napopravku\LaravelAPM\Snapshotting\Data\Snapshots\TimeSnapshot;
use Napopravku\LaravelAPM\Snapshotting\Data\SnapshotsCollection;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsCollector;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;

class SummaryStatisticsCollector implements APMStatisticsCollector
{
    public function collect(SnapshotsCollection $snapshotsCollection): SummaryStatisticsData
    {
        /** @var TimeSnapshot|null $startSnapshot */
        $startSnapshot = Arr::first($snapshotsCollection->getTimeSnapshots());

        /** @var TimeSnapshot|null $endSnapshot */
        $endSnapshot = Arr::last($snapshotsCollection->getTimeSnapshots());

        $start = $startSnapshot->value() ?? 0.0;
        $end   = $endSnapshot->value() ?? 0.0;

        $maxPeakMemory = max(
            array_column($snapshotsCollection->getPeakMemorySnapshots(), 'bytes')
        );

        return SummaryStatisticsData::create($end - $start, $start, $maxPeakMemory);
    }
}
