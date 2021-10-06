<?php

namespace Napopravku\LaravelAPM\Snapshotting\Traits;

trait HasTimestampSnapshot
{
    public float $timestamp;

    public function getTimestamp(): float
    {
        return $this->timestamp;
    }
}
