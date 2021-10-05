<?php

namespace Napopravku\LaravelAPM\Snapshotters;

use Napopravku\LaravelAPM\Contracts\Snapshot;
use Napopravku\LaravelAPM\Contracts\SystemValueSnapshotter;
use Napopravku\LaravelAPM\Data\Snapshots\PeakMemorySnapshot;

class PeakMemorySnapshotter implements SystemValueSnapshotter
{
    /**
     * @param bool $isInitial
     *
     * @return PeakMemorySnapshot
     */
    public function take(bool $isInitial = false): Snapshot
    {
        $value = $isInitial ? 0 : memory_get_peak_usage(true);

        return PeakMemorySnapshot::create($value);
    }
}
