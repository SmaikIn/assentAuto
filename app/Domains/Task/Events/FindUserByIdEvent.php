<?php

namespace App\Domains\Task\Events;

use App\Domains\User\Dto\UserDto;
use Illuminate\Foundation\Events\Dispatchable;

class FindUserByIdEvent
{
    use Dispatchable;

    public function __construct(
        private readonly int $userId,
        private ?UserDto $dto = null
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDto(): ?UserDto
    {
        return $this->dto;
    }

    public function setDto(UserDto $dto): void
    {
        $this->dto = $dto;
    }
}
