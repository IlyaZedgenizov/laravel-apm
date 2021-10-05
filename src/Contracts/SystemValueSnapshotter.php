<?php

namespace Napopravku\LaravelAPM\Contracts;

interface SystemValueSnapshotter
{
    public function take(bool $isInitial = false): Snapshot;
}
