<?php

namespace Napopravku\LaravelAPM\Snapshotting\Data\Snapshots;

use Napopravku\LaravelAPM\Snapshotting\Contacts\NamedSnapshot;
use Napopravku\LaravelAPM\Snapshotting\Traits\HasNameSnapshot;

class TimeSnapshot implements NamedSnapshot
{
    use HasNameSnapshot;

    public float $timestamp;

    public static function create(float $timestamp, string $name): self
    {
        $instance = new static();

        $instance->timestamp = $timestamp;
        $instance->name      = $name;

        return $instance;
    }

    public function value(): float
    {
        return $this->timestamp;
    }
}
