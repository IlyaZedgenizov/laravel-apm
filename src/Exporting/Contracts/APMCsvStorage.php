<?php

namespace Napopravku\LaravelAPM\Exporting\Contracts;

use Napopravku\LaravelAPM\Exporting\Data\CsvStorageOptions;

interface APMCsvStorage
{
    public function initStorage(CsvStorageOptions $options): void;

    public function exists(): bool;

    public function store(string $data): void;
}
