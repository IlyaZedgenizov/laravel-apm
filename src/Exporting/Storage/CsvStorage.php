<?php

namespace Napopravku\LaravelAPM\Exporting\Storage;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use LogicException;
use Napopravku\LaravelAPM\Exporting\Data\CsvStorageOptions;

/**
 * Concurrent-safe storage
 */
class CsvStorage
{
    private const DIR = 'apm/csv';

    private const FILENAME = 'apm';

    private Filesystem $disk;

    private string $filePath;

    public function __construct()
    {
        $this->disk = Storage::disk(config('apm.export.csv.disk'));
    }

    public function initStorage(CsvStorageOptions $options): void
    {
        $today = Carbon::today()->format('Y-m-d');

        $filename = self::FILENAME;
        $dir      = self::DIR;

        if ($options->enableConcurrentSafety) {
            $this->filePath = "$dir/$today/$options->pid/$filename.csv";

            return;
        }

        $this->filePath = "$dir/$today-$filename.csv";
    }

    public function exists(): bool
    {
        return $this->disk->exists($this->getFilePath());
    }

    public function store(string $data): void
    {
        $this->disk->append($this->getFilePath(), $data);
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        if (!$this->filePath) {
            throw new LogicException('You forgot to initialize the storage!');
        }

        return $this->filePath;
    }
}
