<?php

namespace Napopravku\LaravelAPM\Rendering\Listeners;

use Napopravku\LaravelAPM\Rendering\CommandSummaryRenderer;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;
use Napopravku\LaravelAPM\Statistics\Events\StatisticsCollected;
use Napopravku\LaravelAPM\Tasks\Enums\TaskTypes;

class RenderCommandStatistics
{
    private CommandSummaryRenderer $summaryRenderer;

    public function __construct(CommandSummaryRenderer $summaryRenderer)
    {
        $this->summaryRenderer = $summaryRenderer;
    }

    public function handle(StatisticsCollected $event): void
    {
        if ($event->getScriptInfo()->taskType !== TaskTypes::COMMAND) {
            return;
        }

        $statsData = $event->getStatisticsData();

        /*
         * Working only with default implementation. If you have custom stats, implement your own listener
         */
        if (!($statsData instanceof SummaryStatisticsData)) {
            return;
        }

        $this->summaryRenderer->render($statsData);
    }
}
