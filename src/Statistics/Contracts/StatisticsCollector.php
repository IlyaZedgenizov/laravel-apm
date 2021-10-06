<?php

namespace Napopravku\LaravelAPM\Statistics\Contracts;

use Napopravku\LaravelAPM\Snapshotting\Data\SnapshotsCollection;

interface StatisticsCollector
{
    public function collect(SnapshotsCollection $snapshotsCollection): StatisticsData;
}
