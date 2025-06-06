<?php

namespace App\Domains\Task\Events;

use App\Models\Task;
use Illuminate\Foundation\Events\Dispatchable;

final readonly class TaskCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public  Task $taskId,
    )
    {
    }

    public function getTask(): Task
    {
        return $this->taskId;
    }
}
