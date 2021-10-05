<?php

namespace Napopravku\LaravelAPM;

use Napopravku\LaravelAPM\Data\SnapshotsCollection;
use Napopravku\LaravelAPM\Enums\MeasureTypes;
use Napopravku\LaravelAPM\Snapshotters\PeakMemorySnapshotter;
use Napopravku\LaravelAPM\Snapshotters\TimeSnapshotter;

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

        $this->snapshotsCollection = new SnapshotsCollection();
    }

    public function takePeakMemory(bool $isInitial = false): void
    {
        $this->snapshotsCollection->addPeakMemorySnapshot(
            $this->peakMemorySnapshotter->take($isInitial)
        );
    }

    public function takeTime(): void
    {
        $this->snapshotsCollection->addTimeSnapshot(
            $this->timeSnapshotter->take()
        );
    }

    public function takeAll(bool $isInitial = false): void
    {
        /** @var bool[] $measureAvailabilityMap */
        $measureAvailabilityMap = config('apm.mass_measures_available');

        $availableMeasures = array_keys(
            array_filter($measureAvailabilityMap)
        );

        foreach ($availableMeasures as $measure) {
            switch ($measure) {
                case MeasureTypes::TIME:
                    $this->takeTime();
                    break;
                case MeasureTypes::PEAK_MEMORY:
                    $this->takePeakMemory($isInitial);
            }
        }
    }

    public function getSnapshotsCollection(): SnapshotsCollection
    {
        return $this->snapshotsCollection;
    }
}
