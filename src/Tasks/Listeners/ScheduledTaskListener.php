<?php

namespace Napopravku\LaravelAPM\Tasks\Listeners;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\ScriptInfo\SimpleFactories\ScriptInfoFactory;

class ScheduledTaskListener
{
    private APMSnapshotCollector $snapshotCollector;

    private ScriptInfoFactory $scriptInfoFactory;

    public function __construct(APMSnapshotCollector $snapshotCollector, ScriptInfoFactory $scriptInfoFactory)
    {
        $this->snapshotCollector = $snapshotCollector;
        $this->scriptInfoFactory = $scriptInfoFactory;
    }

    public function handleStart(): void
    {
        $this->snapshotCollector->takeForSummary('start');
    }

    public function handleStop(ScheduledTaskFinished $event): void
    {
        $this->snapshotCollector->takeForSummary('stop');

        $scriptInfo = $this->scriptInfoFactory->create($event->task->command, TaskTypes::SCHEDULED_TASK);

        event(
            new SnapshottingFinished($this->snapshotCollector->getSnapshotsCollection(), $scriptInfo)
        );

        $this->terminate();
    }

    public function terminate(): void
    {
        $this->snapshotCollector->resetSnapshotsCollection();
    }
}
