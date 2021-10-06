<?php

namespace Napopravku\LaravelAPM\ScriptInfo\Data;

class ScriptInfo
{
    /**
     * Process id
     */
    public int $pid;

    /**
     * Task type (command, job, request etc)
     * @see TaskTypes
     */
    public int $taskType;

    public string $taskName;
}
