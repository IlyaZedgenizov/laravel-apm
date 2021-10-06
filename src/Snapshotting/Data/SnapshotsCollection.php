<?php

namespace Napopravku\LaravelAPM\Snapshotting\Data;

use Napopravku\LaravelAPM\Snapshotting\Data\Snapshots\PeakMemorySnapshot;
use Napopravku\LaravelAPM\Snapshotting\Data\Snapshots\TimeSnapshot;

class SnapshotsCollection
{
    /**
     * @var PeakMemorySnapshot[]
     */
    private array $peakMemorySnapshots = [];

    /**
     * @var TimeSnapshot[]
     */
    private array $timeSnapshots = [];

    /**
     * @return PeakMemorySnapshot[]
     */
    public function getPeakMemorySnapshots(): array
    {
        return $this->peakMemorySnapshots;
    }

    /**
     * @return TimeSnapshot[]
     */
    public function getTimeSnapshots(): array
    {
        return $this->timeSnapshots;
    }

    public function addPeakMemorySnapshot(PeakMemorySnapshot $snapshot): void
    {
        $this->peakMemorySnapshots[] = $snapshot;
    }

    public function addTimeSnapshot(TimeSnapshot $snapshot): void
    {
        $this->timeSnapshots[] = $snapshot;
    }
}
