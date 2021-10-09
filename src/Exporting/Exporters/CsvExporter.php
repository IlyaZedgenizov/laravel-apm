<?php

namespace Napopravku\LaravelAPM\Exporting\Exporters;

use Napopravku\LaravelAPM\Exporting\Contracts\APMExporter;
use Napopravku\LaravelAPM\Exporting\Exporters\Data\CsvRow;
use Napopravku\LaravelAPM\Exporting\Exporters\DataCreators\CsvRowCreator;
use Napopravku\LaravelAPM\Exporting\Storage\CsvStorage;
use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsData;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;

class CsvExporter implements APMExporter
{
    private CsvStorage $storage;

    private CsvRowCreator $csvRowCreator;

    public function __construct(CsvStorage $storage, CsvRowCreator $csvRowCreator)
    {
        $this->storage       = $storage;
        $this->csvRowCreator = $csvRowCreator;
    }

    /**
     * @param SummaryStatisticsData $statisticsData
     * @param ScriptInfo            $scriptInfo
     */
    public function export(APMStatisticsData $statisticsData, ScriptInfo $scriptInfo): void
    {
        $separator = config('apm.export.csv.separator');

        $data = '';

        if (!$this->storage->exists()) {
            $data = CsvRow::getHeaderRowString($separator);
        }

        $data .= $this
            ->csvRowCreator
            ->createFromStatisticsAndScriptInfo($statisticsData, $scriptInfo)
            ->toRowString($separator);

        $this->storage->store($data);
    }
}
