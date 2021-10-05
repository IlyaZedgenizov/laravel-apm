<?php

namespace Napopravku\LaravelAPM\Data\Snapshots;

use Napopravku\LaravelAPM\Contracts\Snapshot;

class TimeSnapshot implements Snapshot
{
    public int $timestamp;

    public static function create(int $timestamp): self
    {
        $instance = new static();

        $instance->timestamp = $timestamp;

        return $instance;
    }
}
