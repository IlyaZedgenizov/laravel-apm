<?php

namespace Napopravku\LaravelAPM\Snapshotting;

use Napopravku\LaravelAPM\Snapshotting\Data\SnapshotsCollection;
use Napopravku\LaravelAPM\Snapshotting\Enums\SnapshotTypes;
use Napopravku\LaravelAPM\Snapshotting\Snapshotters\PeakMemorySnapshotter;
use Napopravku\LaravelAPM\Snapshotting\Snapshotters\TimeSnapshotter;

class APMSnapshotCollector
{
    private PeakMemorySnapshotter $peakMemorySnapshotter;

    private TimeSnapshotter $timeSnapshotter;

    private SnapshotsCollection $snapshotsCollection;

    public function __construct(
        PeakMemorySnapshotter $peakMemorySnapshotter,
        TimeSnapshotter $timeSnapshotter
    ) {
        $this->peakMemorySnapshotter = $peakMemorySnapshotter;
        $this->timeSnapshotter       = $timeSnapshotter;

        $this->resetSnapshotsCollection();
    }

    public function takePeakMemory(string $name): void
    {
        $this->snapshotsCollection->addPeakMemorySnapshot(
            $this->peakMemorySnapshotter->take($name)
        );
    }

    public function takeTime(string $name): void
    {
        $this->snapshotsCollection->addTimeSnapshot(
            $this->timeSnapshotter->take($name)
        );
    }

    /**
     * Take snapshots for summary results. Includes timestamp and current peak memory
     *
     * @param string $name
     */
    public function takeForSummary(string $name): void
    {
        /** @var bool[] $summarySnapshottingAvailability */
        $summarySnapshottingAvailability = config('apm.summary_snapshotting_availability');

        $availableSnapshotTypes = array_keys(
            array_filter($summarySnapshottingAvailability)
        );

        $this->takeTime($name);

        foreach ($availableSnapshotTypes as $snapshotType) {
            if (SnapshotTypes::isPeakMemory($snapshotType)) {
                $this->takePeakMemory($name);
            }
        }
    }

    public function getSnapshotsCollection(): SnapshotsCollection
    {
        return $this->snapshotsCollection;
    }

    public function resetSnapshotsCollection(): void
    {
        $this->snapshotsCollection = new SnapshotsCollection();
    }
}
