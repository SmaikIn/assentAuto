<?php

declare(strict_types=1);

namespace App\Domains\Task\Dto;


use App\Domains\Task\Enum\UserStatus;

final readonly class UserDto
{
    public function __construct(
        private int $id,
        private string $name,
        private UserStatus $userStatus,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserStatus(): UserStatus
    {
        return $this->userStatus;
    }

}