<?php

namespace Napopravku\LaravelAPM\ScriptInfo\DataCreators;

use Napopravku\LaravelAPM\ScriptInfo\Data\ScriptInfo;

class ScriptInfoCreator
{
    /**
     * @param string $taskName
     * @param int    $entityType
     * @see TaskTypes for $entityType values
     *
     * @return ScriptInfo
     */
    public function create(string $taskName, int $entityType): ScriptInfo
    {
        $scriptInfo = new ScriptInfo();

        $scriptInfo->pid      = getmypid();
        $scriptInfo->taskName = $taskName;
        $scriptInfo->taskType = $entityType;

        return $scriptInfo;
    }
}
