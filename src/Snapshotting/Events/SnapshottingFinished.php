<?php

namespace Napopravku\LaravelAPM\Snapshotting\Events;

use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;
use Napopravku\LaravelAPM\Snapshotting\Data\SnapshotsCollection;

class SnapshottingFinished
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
