<?php

namespace App\Domains\Task\Observers;

use App\Domains\Task\Events\TaskCreatedEvent;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;
use Meilisearch\Client as Meilisearch;

class TaskObserver implements ShouldQueue
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }

    public function created(Task $task): void
    {
        Event::dispatch(new TaskCreatedEvent($task));
        $this->addOrUpdateDoc($task);
    }

    public function updated(Task $task): void
    {
        //Сюда можно добавить проверку статуса и выброса Notification

        $this->addOrUpdateDoc($task);
    }

    public function saved(Task $task): void
    {
        $this->addOrUpdateDoc($task);
    }

    public function deleted(Task $task): void
    {
        $this->meilisearch->getIndex('tasks')->deleteDocument($task->id);
    }

    private function addOrUpdateDoc(Task $task): void
    {
        $data = $task->toArray();

        unset($data['task_status_id']);

        $data['status']['id'] = $task->taskStatus->id;
        $data['status']['name'] = $task->taskStatus->name;
        $data['status']['slug'] = $task->taskStatus->slug;

        $data['users'] = $task->users()->pluck('id')->toArray();

        $this->meilisearch->getIndex('tasks')->addDocuments($data);
    }
}
