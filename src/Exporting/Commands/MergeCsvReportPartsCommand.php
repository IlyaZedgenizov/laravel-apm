<?php

namespace Napopravku\LaravelAPM\Exporting\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Napopravku\LaravelAPM\Exporting\Data\CsvReportRow;
use Napopravku\LaravelAPM\Exporting\Helpers\CsvReportHelper;
use Throwable;

class MergeCsvReportPartsCommand extends Command
{
    public const SIGNATURE = 'apm:merge-csv';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::SIGNATURE . ' {--clear-more-than=7 : How much date-dirs with report parts to keep, the rest will be cleared}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merges parts of report that is split for every pid. Actual only if you have concurrent safety enabled and use its default implementation';

    public function handle(): void
    {
        $this->output->info('Collecting dates...');

        $disk = Storage::disk(config('apm.export.csv.disk'));

        $dates = $this->getSortedDates($disk);

        $this->output->info('Removing old date-dirs with report parts...');

        $dates = $this->getActualDates($disk, $dates);

        $this->output->info('Merging parts...');

        $partsCount = 0;

        foreach ($dates as $date) {
            $this->output->text("Processing $date parts. Preparing result report...");

            $resultFilePath = CsvReportHelper::buildReportPath($date);

            $this->createReport($disk, $resultFilePath);

            $pathByDate = CsvReportHelper::buildReportPartsDirPathByDate($date);

            $filesToMerge = $disk->allFiles($pathByDate);

            $this->mergeParts($disk, $filesToMerge, $resultFilePath);

            $disk->deleteDirectory($pathByDate);

            $partsCount += count($filesToMerge);

            $this->output->info("$date processed!");
        }

        $this->output->info("Finished. Successfully processed $partsCount parts");
    }

    private function getSortedDates(Filesystem $disk): array
    {
        $pathsByDate = $disk->directories(CsvReportHelper::PARTS_DIR);

        $dates = array_map(
            static fn ($path) => basename($path),
            $pathsByDate
        );

        rsort($dates);

        return $dates;
    }

    private function getActualDates(Filesystem $disk, array $dates): array
    {
        $reportsToKeepAmount = $this->option('clear-more-than');

        $expiredDates = array_slice($dates, $reportsToKeepAmount);

        foreach ($expiredDates as $expiredDate) {
            $disk->deleteDirectory(
                CsvReportHelper::buildReportPartsDirPathByDate($expiredDate)
            );
        }

        return array_slice($dates, 0, $reportsToKeepAmount);
    }

    private function createReport(Filesystem $disk, string $resultFilePath): void
    {
        $newFileContents = CsvReportRow::getHeaderRowString() . PHP_EOL;

        $disk->put($resultFilePath, $newFileContents);
    }

    private function mergeParts(Filesystem $disk, array $filesToMerge, string $resultFilePath): void
    {
        foreach ($filesToMerge as $filePath) {
            $this->output->text("Merging part $filePath...");

            try {
                $disk->append($resultFilePath, $disk->get($filePath));
            } catch (Throwable $e) {
                $this->output->warning("Could not access file $filePath: " . $e->getMessage());
            }
        }
    }
}
