<?php

use Napopravku\LaravelAPM\Enums\MeasureTypes;

return [
    'mass_measures_available' => [
        MeasureTypes::TIME        => env('APM_MEASURE_TIME_ENABLED', true),
        MeasureTypes::PEAK_MEMORY => env('APM_MEASURE_MEMORY_ENABLED', true),
    ],
];
