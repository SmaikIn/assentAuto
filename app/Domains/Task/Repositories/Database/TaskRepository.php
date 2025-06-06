<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories\Database;

use App\Domains\Task\Dto\TaskDto;
use App\Domains\Task\Enum\TaskStatus as TaskStatusEnum;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Carbon\Carbon;
use Throwable;

final class TaskRepository
{

    /**
     * @param  TaskDto  $dto
     * @return TaskDto
     * @throws Throwable
     */
    public function create(TaskDto $dto): TaskDto
    {
        $task = new Task;

        $task->title = $dto->getTitle();
        $task->description = $dto->getDescription();
        $task->taskStatus = TaskStatus::where('slug', $dto->getStatus())->first()->id;

        $task->saveOrFail();
        $task->refresh();

        return $this->_formatDto($task);
    }

    /**
     * @param  TaskDto  $dto
     * @return TaskDto
     * @throws Throwable
     */
    public function update(TaskDto $dto): TaskDto
    {
        $task = Task::where('id', $dto->getId())->firstOrFail();

        $task->title = $dto->getTitle();
        $task->description = $dto->getDescription();
        $task->taskStatus = TaskStatus::where('slug', $dto->getStatus())->first()->id;

        $task->saveOrFail();
        $task->refresh();

        return $this->_formatDto($task);
    }

    /**
     * @param  int  $taskId
     * @return bool|null
     * @throws Throwable
     */
    public function deleteById(int $taskId): ?bool
    {
        return User::where('id', $taskId)->firstOrFail()->deleteOrFail();
    }

    public function assignUser(int $taskId, int $userId): void
    {
        Task::where('id', $taskId)->firstOrFail()->users()->attach($userId);
    }

    public function detachUser(int $taskId, int $userId): void
    {
        Task::where('id', $taskId)->firstOrFail()->users()->detach($userId);
    }

    private function _formatDto(Task $task): TaskDto
    {
        return new TaskDto(
            id: $task->id,
            title: $task->title,
            description: $task->description,
            status: TaskStatusEnum::tryFrom($task->taskStatus->slug),
            createdAt: Carbon::parse($task->created_at),
            updatedAt: Carbon::parse($task->updated_at),
        );
    }


}