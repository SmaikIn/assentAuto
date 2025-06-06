<?php

namespace App\Domains\Task\Listeners;

use App\Domains\Task\Events\TaskCreatedEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskCreatedListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public int $delay = 100;

    public function handle(TaskCreatedEvent $event)
    {
        $task = $event->getTask();

        $task->refresh();

        if ($task->users()->count() <= 0) {
            $user = User::inRandomOrder()->first();
            $task->users()->attach($user);
        }
    }
}
