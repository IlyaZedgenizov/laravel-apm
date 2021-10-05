<?php

namespace Napopravku\LaravelAPM\Data\Snapshots;

use Napopravku\LaravelAPM\Contracts\Snapshot;

class PeakMemorySnapshot implements Snapshot
{
    public int $bytes;

    public static function create(int $bytes): self
    {
        $instance = new static();

        $instance->bytes = $bytes;

        return $instance;
    }
}
