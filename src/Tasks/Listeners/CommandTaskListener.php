<?php

namespace Napopravku\LaravelAPM\Tasks\Listeners;

use Illuminate\Console\Events\CommandFinished;
use Napopravku\LaravelAPM\ScriptInfo\DataCreators\ScriptInfoCreator;
use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;

class CommandTaskListener
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

    public function handleStop(CommandFinished $event): void
    {
        $this->snapshotCollector->takeDefaults('stop');

        $scriptInfo = $this->scriptInfoCreator->create($event->command, TaskTypes::COMMAND);

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
