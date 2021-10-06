<?php

namespace Napopravku\LaravelAPM\Snapshotting\Snapshotters;

use Napopravku\LaravelAPM\Snapshotting\Contacts\InternValueSnapshotter;
use Napopravku\LaravelAPM\Snapshotting\Data\Snapshots\PeakMemorySnapshot;

class PeakMemorySnapshotter implements InternValueSnapshotter
{
    public function take(string $name): PeakMemorySnapshot
    {
        return PeakMemorySnapshot::create(
            memory_get_peak_usage(true),
            $name,
            microtime(true)
        );
    }
}
