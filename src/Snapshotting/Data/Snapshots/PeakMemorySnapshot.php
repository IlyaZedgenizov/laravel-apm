<?php

namespace Napopravku\LaravelAPM\Snapshotting\Data\Snapshots;

use Napopravku\LaravelAPM\Snapshotting\Contacts\NamedSnapshot;
use Napopravku\LaravelAPM\Snapshotting\Contacts\TimestampedSnapshot;
use Napopravku\LaravelAPM\Snapshotting\Traits\HasNameSnapshot;
use Napopravku\LaravelAPM\Snapshotting\Traits\HasTimestampSnapshot;

class PeakMemorySnapshot implements NamedSnapshot, TimestampedSnapshot
{
    use HasNameSnapshot;
    use HasTimestampSnapshot;

    public int $bytes;

    public static function create(int $bytes, string $name, float $timestamp): self
    {
        $instance = new static();

        $instance->bytes     = $bytes;
        $instance->name      = $name;
        $instance->timestamp = $timestamp;

        return $instance;
    }

    public function value(): int
    {
        return $this->bytes;
    }
}
