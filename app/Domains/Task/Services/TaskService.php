<?php

declare(strict_types=1);

namespace App\Domains\Task\Services;

use App\Domains\Shared\Exceptions\DatabaseException;
use App\Domains\Shared\Exceptions\NotFoundException;
use App\Domains\Shared\Exceptions\ServiceException;
use App\Domains\Task\Dto\TaskDto;
use App\Domains\Task\Enum\UserStatus;
use App\Domains\Task\Repositories\Database\TaskRepository;
use App\Domains\Task\Repositories\Remoutes\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Throwable;

final readonly class TaskService
{
    public function __construct(
        private UserRepository $userRepository,
        private TaskRepository $taskRepository,
    ) {
    }


    public function create(TaskDto $dto): ?TaskDto
    {
        try {
            return $this->taskRepository->create($dto);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }

    public function update(TaskDto $dto): TaskDto
    {
        try {
            return $this->taskRepository->update($dto);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User", previous: $e);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }

    public function delete(int $id): bool
    {
        try {
            return $this->taskRepository->deleteById($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User", previous: $e);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }

    public function assignUser(int $taskId, int $userId): void
    {

        $user = $this->userRepository->getUserById($userId);

        if($user->getUserStatus() == UserStatus::Vacation){
            throw new ServiceException("User in Vacation", Response::HTTP_CONFLICT);
        }

        try {
            $this->taskRepository->assignUser($taskId, $userId);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User", previous: $e);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }

    public function detachUser(int $taskId, int $userId): void
    {
        try {
            $this->taskRepository->detachUser($taskId, $userId);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User", previous: $e);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }
}