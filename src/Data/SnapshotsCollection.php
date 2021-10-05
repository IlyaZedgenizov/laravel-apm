<?php

namespace Napopravku\LaravelAPM\Data;

use Napopravku\LaravelAPM\Contracts\Snapshot;
use Napopravku\LaravelAPM\Data\Snapshots\PeakMemorySnapshot;
use Napopravku\LaravelAPM\Data\Snapshots\TimeSnapshot;

class SnapshotsCollection
{
    /**
     * @var Snapshot[]
     */
    private array $peakMemorySnapshots = [];

    /**
     * @var Snapshot[]
     */
    private array $timeSnapshots = [];

    /**
     * @return Snapshot[]
     */
    public function getPeakMemorySnapshots(): array
    {
        return $this->peakMemorySnapshots;
    }

    /**
     * @return Snapshot[]
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
