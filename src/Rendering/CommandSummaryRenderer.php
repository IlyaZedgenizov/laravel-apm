<?php

namespace Napopravku\LaravelAPM\Rendering;

use Napopravku\LaravelAPM\Formatting\MemoryFormatter;
use Napopravku\LaravelAPM\Formatting\TimeFormatter;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;
use Symfony\Component\Console\Output\ConsoleOutput;

class CommandSummaryRenderer
{
    private const LONG_DURATION   = 60;
    private const MEDIUM_DURATION = 20;

    private const BIG_MEMORY_USAGE    = 1024 ** 3;
    private const MEDIUM_MEMORY_USAGE = self::BIG_MEMORY_USAGE / 3;

    private ConsoleOutput $output;

    public function __construct(ConsoleOutput $output)
    {
        $this->output = $output;
    }

    public function render(SummaryStatisticsData $statisticsData): void
    {
        $durationColor = 'green';
        $peakMemColor  = 'green';

        if ($statisticsData->executionTime > self::LONG_DURATION) {
            $durationColor = 'red';
        } elseif ($statisticsData->executionTime > self::MEDIUM_DURATION) {
            $durationColor = 'yellow';
        }

        if ($statisticsData->peakMemory > self::BIG_MEMORY_USAGE) {
            $peakMemColor = 'red';
        } elseif ($statisticsData->peakMemory > self::MEDIUM_MEMORY_USAGE) {
            $peakMemColor = 'yellow';
        }

        $duration   = TimeFormatter::format((int)$statisticsData->executionTime);
        $peakMemory = MemoryFormatter::format($statisticsData->peakMemory);

        $this->output->writeln(
            "\n<fg=white;bg=green>APM:</> Script executed."
            . "Duration: <bg=$durationColor;options=bold>$duration</>, "
            . "peak memory: <bg=$peakMemColor;options=bold>$peakMemory</>"
        );
    }
}
