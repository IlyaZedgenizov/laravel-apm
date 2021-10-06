<?php

namespace Napopravku\LaravelAPM\Snapshotting\Contacts;

interface TimestampedSnapshot
{
    public function getTimestamp(): float;
}
