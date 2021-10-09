<?php

namespace Napopravku\LaravelAPM\Tasks\Listeners;

use Illuminate\Queue\Events\JobProcessed;
use Napopravku\LaravelAPM\ScriptInfo\SimpleFactories\ScriptInfoFactory;
use Napopravku\LaravelAPM\Snapshotting\APMSnapshotCollector;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;

class JobTaskListener
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

    public function handleStop(JobProcessed $event): void
    {
        $this->snapshotCollector->takeForSummary('stop');

        $scriptInfo = $this->scriptInfoFactory->create($event->job->resolveName(), TaskTypes::JOB);

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
