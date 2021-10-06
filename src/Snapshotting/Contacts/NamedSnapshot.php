<?php

namespace Napopravku\LaravelAPM\Snapshotting\Contacts;

interface NamedSnapshot extends Snapshot
{
    public function getName(): string;
}
