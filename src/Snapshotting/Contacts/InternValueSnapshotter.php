<?php

namespace Napopravku\LaravelAPM\Snapshotting\Contacts;

/**
 * Snapshotters that get values from internal sources (system, etc.)
 * All snapshots will have names, so it returns NamedSnapshot
 */
interface InternValueSnapshotter
{
    public function take(string $name): NamedSnapshot;
}
