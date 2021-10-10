<?php

namespace Napopravku\LaravelAPM\Exporting\Storage;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use LogicException;
use Napopravku\LaravelAPM\Exporting\Contracts\APMCsvReportStorage;
use Napopravku\LaravelAPM\Exporting\Data\CsvReportStorageOptions;
use Napopravku\LaravelAPM\Exporting\Helpers\CsvReportHelper;

/**
 * Concurrent-safe storage
 */
class CsvReportStorage implements APMCsvReportStorage
{
    private Filesystem $disk;

    private string $filePath;

    public function initStorage(CsvReportStorageOptions $options): void
    {
        $this->disk = Storage::disk(config('apm.export.csv.disk'));

        $today = Carbon::today()->format(CsvReportHelper::FILENAME_DATE_FORMAT);

        if ($options->enableConcurrentSafety) {
            $this->filePath = CsvReportHelper::buildReportPartPath($today, $options->pid ?? 0);

            return;
        }

        $this->filePath = CsvReportHelper::buildReportPath($today);
    }

    public function exists(): bool
    {
        return $this->disk->exists($this->getFilePath());
    }

    public function store(string $data): void
    {
        $this->disk->append($this->getFilePath(), $data);
    }

    public function getFilePath(): string
    {
        if (!$this->filePath) {
            throw new LogicException('You forgot to initialize the storage!');
        }

        return $this->filePath;
    }
}
