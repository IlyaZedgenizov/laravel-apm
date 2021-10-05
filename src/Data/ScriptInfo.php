<?php

namespace Napopravku\LaravelAPM\Data;

class ScriptInfo
{
    /**
     * Process id
     */
    public int $pid;

    /**
     * Script type (command, job, request etc)
     * @see ScriptTypes
     */
    public int $entityType;

    public string $entityName;
}
