<?php

namespace Napopravku\LaravelAPM\Listeners;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Napopravku\LaravelAPM\APMSnapshotCollector;
use Napopravku\LaravelAPM\Enums\ScriptTypes;
use Napopravku\LaravelAPM\Events\MeasuringFinished;
use Napopravku\LaravelAPM\Services\ScriptInfoCreator;

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
        $this->snapshotCollector->takeAll(true);
    }

    public function handleStop(ScheduledTaskFinished $event): void
    {
        $this->snapshotCollector->takeAll();

        $scriptInfo = $this->scriptInfoCreator->create($event->task, ScriptTypes::SCHEDULED_TASK);

        event(
            new MeasuringFinished($this->snapshotCollector->getSnapshotsCollection(), $scriptInfo)
        );
    }
}
