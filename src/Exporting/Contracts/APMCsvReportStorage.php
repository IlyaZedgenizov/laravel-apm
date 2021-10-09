<?php

namespace Napopravku\LaravelAPM\Exporting\Contracts;

use Napopravku\LaravelAPM\Exporting\Data\CsvReportStorageOptions;

interface APMCsvReportStorage
{
    public function initStorage(CsvReportStorageOptions $options): void;

    public function exists(): bool;

    public function store(string $data): void;
}
