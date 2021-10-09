<?php

namespace Napopravku\LaravelAPM\Statistics\Contracts;

use Napopravku\LaravelAPM\Snapshotting\Data\SnapshotsCollection;

interface APMStatisticsCollector
{
    public function collect(SnapshotsCollection $snapshotsCollection): APMStatisticsData;
}
