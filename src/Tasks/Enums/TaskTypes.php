<?php

namespace Napopravku\LaravelAPM\Tasks\Enums;

/**
 * I could use some cool libs like spatie/enum, but it's not necessary here
 */
class TaskTypes
{
    public const JOB = 1;

    public const COMMAND = 2;

    public const SCHEDULED_TASK = 3;

    // Not implemented yet
    public const REQUEST = 4;

    // Not implemented yet
    public const DB_QUERY = 5;

    public const DESCRIPTIONS = [
        self::JOB            => 'job',
        self::COMMAND        => 'command',
        self::SCHEDULED_TASK => 'scheduled',
        self::REQUEST        => 'request',
        self::DB_QUERY       => 'db_query',
    ];
}
