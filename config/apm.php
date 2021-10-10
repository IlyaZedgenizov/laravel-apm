<?php

use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;

return [
    /*
     * If you have your app running in multiple processes,
     * apm needs to handle concurrent storage access when saving metrics
     */
    'enable_concurrent_safety' => env('APM_ENABLE_CONCURRENT_SAFETY', true),

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
            'separator' => env('APM_CSV_SEPARATOR', ','),
            'disk'      => env('FILESYSTEM_DRIVER', 'local'),

            /*
             * Due to current inter-process results storing implementation,
             * default value depends on APM_ENABLE_CONCURRENT_SAFETY.
             * See README.md for more information about the implementation
             */
            'include_header' => env(
                'APM_CSV_INCLUDE_HEADER',
                !env('APM_ENABLE_CONCURRENT_SAFETY', true)
            ),
        ],
    ],

    'timezone' => env('APP_TIMEZONE', 'Europe/Moscow'),

    'reports_ttl_days' => env('APM_REPORTS_TTL_DAYS', 7),
];
