<?php

namespace Napopravku\LaravelAPM\Snapshotting\Listeners;

use Napopravku\LaravelAPM\Exporting\Contracts\APMReportExporter;
use Napopravku\LaravelAPM\Snapshotting\Events\SnapshottingFinished;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsCollector;
use Napopravku\LaravelAPM\Statistics\Events\StatisticsCollected;

class SnapshottingFinishedListener
{
    private APMStatisticsCollector $statisticsCollector;

    private APMReportExporter $exporter;

    public function __construct(
        APMStatisticsCollector $statisticsCollector,
        APMReportExporter $exporter
    ) {
        $this->statisticsCollector = $statisticsCollector;
        $this->exporter            = $exporter;
    }

    public function handle(SnapshottingFinished $event): void
    {
        $scriptInfo = $event->getScriptInfo();

        $statisticsData = $this->statisticsCollector->collect($event->getSnapshotsCollection());

        event(
            new StatisticsCollected($statisticsData, $scriptInfo)
        );

        /*
         * Despite it depends on statistics data and could listen to StatisticsCollected event,
         * it is default regular action, and the event is for some additional actions on collected stats
         */
        $this->exporter->export($statisticsData, $scriptInfo);
    }
}
