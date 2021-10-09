<?php

namespace Napopravku\LaravelAPM\Snapshotting\Listeners;

use Napopravku\LaravelAPM\Exporting\Contracts\APMExporter;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsCollector;

class SnapshottingFinishedListener
{
    private APMStatisticsCollector $statisticsCollector;

    private APMExporter $exporter;

    public function __construct(
        APMStatisticsCollector $statisticsCollector,
        APMExporter $exporter
    ) {
        $this->statisticsCollector = $statisticsCollector;
        $this->exporter            = $exporter;
    }

    public function handle(SnapshottingFinished $event): void
    {
        $statisticsData = $this->statisticsCollector->collect($event->getSnapshotsCollection());

        $this->exporter->export($statisticsData, $event->getScriptInfo());
    }
}
