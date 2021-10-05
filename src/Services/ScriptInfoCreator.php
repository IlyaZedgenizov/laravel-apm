<?php

namespace Napopravku\LaravelAPM\Services;

use Illuminate\Console\Scheduling\Event;
use Napopravku\LaravelAPM\Data\ScriptInfo;

class ScriptInfoCreator
{
    /**
     * @param Event $task
     * @param int   $entityType
     * @see ScriptTypes for $entityType values
     *
     * @return ScriptInfo
     */
    public function create(Event $task, int $entityType): ScriptInfo
    {
        $scriptInfo = new ScriptInfo();

        $scriptInfo->pid        = getmypid();
        $scriptInfo->entityType = $entityType;
        $scriptInfo->entityName = $task->getSummaryForDisplay();

        return $scriptInfo;
    }
}
