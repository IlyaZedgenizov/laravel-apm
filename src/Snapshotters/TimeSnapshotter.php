<?php

namespace Napopravku\LaravelAPM\Snapshotters;

use Napopravku\LaravelAPM\Contracts\Snapshot;
use Napopravku\LaravelAPM\Contracts\SystemValueSnapshotter;
use Napopravku\LaravelAPM\Data\Snapshots\TimeSnapshot;

class TimeSnapshotter implements SystemValueSnapshotter
{
    /**
     * @param bool $isInitial
     *
     * @return TimeSnapshot
     */
    public function take(bool $isInitial = false): Snapshot
    {
        return TimeSnapshot::create(microtime(true));
    }
}
