<?php

namespace Napopravku\LaravelAPM\Exporting\Exporters;

use Napopravku\LaravelAPM\Exporting\Contracts\APMCsvReportStorage;
use Napopravku\LaravelAPM\Exporting\Contracts\APMReportExporter;
use Napopravku\LaravelAPM\Exporting\Data\CsvReportRow;
use Napopravku\LaravelAPM\Exporting\Data\CsvReportStorageOptions;
use Napopravku\LaravelAPM\Exporting\SimpleFactories\CsvReportRowFactory;
use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsData;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;

class CsvReportExporter implements APMReportExporter
{
    private APMCsvReportStorage $storage;

    private CsvReportRowFactory $csvRowFactory;

    public function __construct(APMCsvReportStorage $storage, CsvReportRowFactory $csvRowFactory)
    {
        $this->storage       = $storage;
        $this->csvRowFactory = $csvRowFactory;
    }

    /**
     * @param SummaryStatisticsData $statisticsData
     * @param ScriptInfo            $scriptInfo
     */
    public function export(APMStatisticsData $statisticsData, ScriptInfo $scriptInfo): void
    {
        $this->storage->initStorage(
            CsvReportStorageOptions::create($scriptInfo->pid, config('apm.enable_concurrent_safety'))
        );

        $separator = config('apm.export.csv.separator');

        $data = '';

        if ($this->shouldStoreHeader()) {
            $data = CsvReportRow::getHeaderRowString($separator) . PHP_EOL;
        }

        $data .= $this
            ->csvRowFactory
            ->fromStatisticsAndScriptInfo($statisticsData, $scriptInfo)
            ->toRowString($separator);

        $this->storage->store($data);
    }

    protected function shouldStoreHeader(): bool
    {
        return config('apm.export.csv.include_header') && !$this->storage->exists();
    }
}
