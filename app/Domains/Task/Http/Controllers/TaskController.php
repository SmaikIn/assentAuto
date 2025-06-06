<?php

declare(strict_types=1);

namespace App\Domains\Task\Http\Controllers;

use App\Domains\Shared\Responses\JsonApiResponse;
use App\Domains\Shared\Responses\JsonErrorResponse;
use App\Domains\Task\Dto\TaskDto;
use App\Domains\Task\Enum\TaskStatus;
use App\Domains\Task\Http\Requests\TaskAssignUserRequest;
use App\Domains\Task\Http\Requests\TaskCreateRequest;
use App\Domains\Task\Http\Requests\TaskDeleteRequest;
use App\Domains\Task\Http\Requests\TaskDetachUserRequest;
use App\Domains\Task\Http\Requests\TaskUpdateRequest;
use App\Domains\Task\Http\Resources\TaskResource;
use App\Domains\Task\Services\TaskService;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as CodeResponse;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {
    }

    public function create(TaskCreateRequest $request): JsonApiResponse|JsonErrorResponse
    {
        $taskDto = new TaskDto(
            id: null,
            title: $request->input('title'),
            description: $request->input('description'),
            status: TaskStatus::tryFrom($request->input('taskStatus')),
            createdAt: null,
            updatedAt: null
        );


        $task = $this->taskService->create($taskDto);

        return new JsonApiResponse(TaskResource::make($task)->toArray($request), status: CodeResponse::HTTP_CREATED);
    }

    public function update(TaskUpdateRequest $request): JsonApiResponse
    {
        $taskDto = new TaskDto(
            id: null,
            title: $request->input('title'),
            description: $request->input('description'),
            status: TaskStatus::tryFrom($request->input('taskStatus')),
            createdAt: null,
            updatedAt: null
        );

        $this->taskService->update($taskDto);

        return new JsonApiResponse([], status: CodeResponse::HTTP_OK);
    }

    public function delete(TaskDeleteRequest $request): JsonApiResponse
    {
        $taskId = $request->input('taskId');

        $this->taskService->delete($taskId);

        return new JsonApiResponse([], status: CodeResponse::HTTP_NO_CONTENT);
    }


    public function assignUser(TaskAssignUserRequest $request)
    {
        $this->taskService->assignUser($request->input('taskId'), $request->input('userId'));

        return new JsonApiResponse([], status: CodeResponse::HTTP_NO_CONTENT);
    }

    public function detachUser(TaskDetachUserRequest $request)
    {
        $this->taskService->detachUser($request->input('taskId'), $request->input('userId'));

        return new JsonApiResponse([], status: CodeResponse::HTTP_NO_CONTENT);
    }
}
