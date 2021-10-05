<?php

namespace Napopravku\LaravelAPM\Events;

use Napopravku\LaravelAPM\Data\ScriptInfo;
use Napopravku\LaravelAPM\Data\SnapshotsCollection;

class MeasuringFinished
{
    private SnapshotsCollection $snapshotsCollection;

    private ScriptInfo $scriptInfo;

    public function __construct(SnapshotsCollection $snapshotsCollection, ScriptInfo $scriptInfo)
    {
        $this->snapshotsCollection = $snapshotsCollection;
        $this->scriptInfo          = $scriptInfo;
    }

    /**
     * @return SnapshotsCollection
     */
    public function getSnapshotsCollection(): SnapshotsCollection
    {
        return $this->snapshotsCollection;
    }

    /**
     * @return ScriptInfo
     */
    public function getScriptInfo(): ScriptInfo
    {
        return $this->scriptInfo;
    }
}
