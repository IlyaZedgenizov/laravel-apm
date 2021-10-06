<?php

use Napopravku\LaravelAPM\Snapshotting\Enums\SnapshotTypes;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;

return [
    /*
     * Snapshots availability matrix when making default tasks snapshotting
     */
    'default_snapshotting_availability' => [
        SnapshotTypes::PEAK_MEMORY => env('APM_DEFAULT_SNAPSHOTTING_PEAK_MEMORY', true),
    ],

    /*
     * Prod configuration. Locally, turn off scheduler and turn on commands
     */
    'tasks_available' => [
        TaskTypes::JOB            => env('APM_JOBS_ENABLE', true),
        TaskTypes::COMMAND        => env('APM_COMMANDS_ENABLE', false),
        TaskTypes::SCHEDULED_TASK => env('APM_SCHEDULER_ENABLE', true),
    ],

    'formats' => [
        /*
         * Standard php DateTime format
         */
        'date' => env('APM_DATE_FORMAT', 'Y-m-d H:i:s'),

        /*
         * Standard php DateInterval format
         */
        'time' => env('APM_TIME_FORMAT', '%H:%I:%S'),
    ],

    'export' => [
        'csv' => [
            'filename'  => env('APM_CSV_FILENAME', 'apm'),
            'separator' => env('APM_CSV_SEPARATOR', ','),
            'disk'      => env('FILESYSTEM_DRIVER', 'local'),
        ],
    ],

    'timezone' => env('APP_TIMEZONE', 'Europe/Moscow'),
];
