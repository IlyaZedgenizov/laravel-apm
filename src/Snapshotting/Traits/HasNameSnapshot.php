<?php

namespace Napopravku\LaravelAPM\Snapshotting\Traits;

trait HasNameSnapshot
{
    public string $name;

    public function getName(): string
    {
        return $this->name;
    }
}
