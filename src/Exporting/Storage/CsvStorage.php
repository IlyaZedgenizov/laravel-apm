<?php

namespace Napopravku\LaravelAPM\Exporting\Storage;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CsvStorage
{
    private const DIR = 'apm/csv';

    private Filesystem $disk;

    private string $filePath;

    public function __construct()
    {
        $this->disk     = Storage::disk(config('apm.export.csv.disk'));
        $this->filePath = $this->getFilePath();
    }

    public function exists(): bool
    {
        return $this->disk->exists($this->filePath);
    }

    public function store(string $data): void
    {
        $this->disk->append($this->filePath, $data);
    }

    private function getFilePath(): string
    {
        $today    = Carbon::today()->format('Y-m-d');
        $filename = config('apm.export.csv.filename');

        $dir = self::DIR;

        return "$dir/$today-$filename.csv";
    }
}
