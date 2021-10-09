<?php

namespace Napopravku\LaravelAPM;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Events\ScheduledTaskFailed;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;
use Napopravku\LaravelAPM\Exporting\Contracts\APMCsvReportStorage;
use Napopravku\LaravelAPM\Exporting\Contracts\APMReportExporter;
use Napopravku\LaravelAPM\Exporting\Exporters\CsvReportExporter;
use Napopravku\LaravelAPM\Exporting\Storage\CsvReportStorage;
use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;
use Napopravku\LaravelAPM\Statistics\Collectors\SummaryStatisticsCollector;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsCollector;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\Snapshotting\Listeners\SnapshottingFinishedListener;
use Napopravku\LaravelAPM\Tasks\Listeners\CommandTaskListener;
use Napopravku\LaravelAPM\Tasks\Listeners\JobTaskListener;
use Napopravku\LaravelAPM\Tasks\Listeners\ScheduledTaskListener;

class APMServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    /**
     * @throws BindingResolutionException
     */
    public function register()
    {
        $config_path = __DIR__ . '/../config/apm.php';
        $this->mergeConfigFrom($config_path, 'apm');

        /** @var Dispatcher $events */
        $events = $this->app->make('events');

        /** @var Config $config */
        $config = $this->app->make('config');

        $scriptTypesAvailable = $config->get('apm.tasks_available');

        if(!$this->app->bound(APMStatisticsCollector::class)) {
            $this->app->bind(APMStatisticsCollector::class, SummaryStatisticsCollector::class);
        }

        if(!$this->app->bound(APMReportExporter::class)) {
            $this->app->bind(APMReportExporter::class, CsvReportExporter::class);
        }

        if(!$this->app->bound(APMCsvReportStorage::class)) {
            $this->app->bind(APMCsvReportStorage::class, CsvReportStorage::class);
        }

        $this->app->singleton(APMSnapshotCollector::class);

        $events->listen(SnapshottingFinished::class, [SnapshottingFinishedListener::class, 'handle']);

        if ($scriptTypesAvailable[TaskTypes::JOB]) {
            $events->listen(JobProcessing::class, [JobTaskListener::class, 'handleStart']);
            $events->listen(JobProcessed::class,  [JobTaskListener::class, 'handleStop']);
            $events->listen(JobFailed::class,     [JobTaskListener::class, 'terminate']);
        }

        if ($scriptTypesAvailable[TaskTypes::COMMAND]) {
            $events->listen(CommandStarting::class, [CommandTaskListener::class, 'handleStart']);
            $events->listen(CommandFinished::class, [CommandTaskListener::class, 'handleStop']);
        }

        if ($scriptTypesAvailable[TaskTypes::SCHEDULED_TASK]) {
            $events->listen(ScheduledTaskStarting::class, [ScheduledTaskListener::class, 'handleStart']);
            $events->listen(ScheduledTaskFinished::class, [ScheduledTaskListener::class, 'handleStop']);
            $events->listen(ScheduledTaskFailed::class,   [ScheduledTaskListener::class, 'terminate']);
        }
    }
}
