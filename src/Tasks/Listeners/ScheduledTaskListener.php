<?php

namespace Napopravku\LaravelAPM\Tasks\Listeners;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\ScriptInfo\DataCreators\ScriptInfoCreator;

class ScheduledTaskListener
{
    private APMSnapshotCollector $snapshotCollector;

    private ScriptInfoCreator $scriptInfoCreator;

    public function __construct(APMSnapshotCollector $snapshotCollector, ScriptInfoCreator $scriptInfoCreator)
    {
        $this->snapshotCollector = $snapshotCollector;
        $this->scriptInfoCreator = $scriptInfoCreator;
    }

    public function handleStart(): void
    {
        $this->snapshotCollector->takeDefaults('start');
    }

    public function handleStop(ScheduledTaskFinished $event): void
    {
        $this->snapshotCollector->takeDefaults('stop');

        $scriptInfo = $this->scriptInfoCreator->create($event->task->command, TaskTypes::SCHEDULED_TASK);

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
