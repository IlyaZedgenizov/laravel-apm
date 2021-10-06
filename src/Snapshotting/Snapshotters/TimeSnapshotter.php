<?php

namespace Napopravku\LaravelAPM\Snapshotting\Snapshotters;

use Napopravku\LaravelAPM\Snapshotting\Contacts\InternValueSnapshotter;
use Napopravku\LaravelAPM\Snapshotting\Data\Snapshots\TimeSnapshot;

class TimeSnapshotter implements InternValueSnapshotter
{
    public function take(string $name): TimeSnapshot
    {
        return TimeSnapshot::create(microtime(true), $name);
    }
}
