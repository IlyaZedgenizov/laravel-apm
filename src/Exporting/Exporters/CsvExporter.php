<?php

namespace Napopravku\LaravelAPM\Exporting\Exporters;

use Napopravku\LaravelAPM\Exporting\Contracts\APMCsvStorage;
use Napopravku\LaravelAPM\Exporting\Contracts\APMExporter;
use Napopravku\LaravelAPM\Exporting\Data\CsvRow;
use Napopravku\LaravelAPM\Exporting\Data\CsvStorageOptions;
use Napopravku\LaravelAPM\Exporting\SimpleFactories\CsvRowFactory;
use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Statistics\Contracts\APMStatisticsData;
use Napopravku\LaravelAPM\Statistics\Data\SummaryStatisticsData;

class CsvExporter implements APMExporter
{
    private APMCsvStorage $storage;

    private CsvRowFactory $csvRowFactory;

    public function __construct(APMCsvStorage $storage, CsvRowFactory $csvRowFactory)
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
            CsvStorageOptions::create($scriptInfo->pid, config('apm.enable_concurrent_safety'))
        );

        $separator = config('apm.export.csv.separator');

        $data = '';

        if ($this->shouldStoreHeader()) {
            $data = CsvRow::getHeaderRowString($separator) . PHP_EOL;
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
