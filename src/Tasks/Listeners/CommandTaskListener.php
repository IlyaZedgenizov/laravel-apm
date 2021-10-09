<?php

namespace Napopravku\LaravelAPM\Tasks\Listeners;

use Illuminate\Console\Events\CommandFinished;
use Napopravku\LaravelAPM\ScriptInfo\SimpleFactories\ScriptInfoFactory;
use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;

class CommandTaskListener
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

    public function handleStop(CommandFinished $event): void
    {
        $this->snapshotCollector->takeForSummary('stop');

        $scriptInfo = $this->scriptInfoFactory->create($event->command, TaskTypes::COMMAND);

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
