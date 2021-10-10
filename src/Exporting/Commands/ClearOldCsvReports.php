<?php

namespace Napopravku\LaravelAPM\Exporting\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Napopravku\LaravelAPM\Exporting\Helpers\CsvReportHelper;
use Throwable;

class ClearOldCsvReports extends Command
{
    public const SIGNATURE = 'apm:clear';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::SIGNATURE;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old csv reports';

    public function handle(): void
    {
        $disk = Storage::disk(config('apm.export.csv.disk'));

        $reports = $disk->files(CsvReportHelper::DIR);

        $minDate = Carbon::today()->subDays(config('apm.reports_ttl_days'));

        $this->output->text('Clearing old reports...');

        $deletedCount = 0;

        foreach ($reports as $report) {
            $dateStr = Arr::first(
                explode('.', basename($report))
            );

            try {
                $date = Carbon::parse($dateStr);
            } catch (Throwable $e) {
                $this->output->warning("Skipped report $report: could not parse date");

                continue;
            }

            if ($date->lessThan($minDate)) {
                $disk->delete($report);

                $deletedCount++;

                $this->output->text("Deleted report $report");
            }
        }

        if ($deletedCount) {
            $this->output->info("Successfully deleted $deletedCount reports!");
        } else {
            $this->output->text("No reports to delete");
        }
    }
}
