<?php

namespace App\Domains\Task\Repositories\Remoutes;

use App\Domains\Task\Dto\UserDto;
use App\Domains\Task\Enum\UserStatus;
use App\Domains\Task\Events\FindUserByIdEvent;
use Illuminate\Support\Facades\Event;

class UserRepository
{
    public function getUserById(int $id): ?UserDto
    {
        $event = new FindUserByIdEvent(userId: $id);

        Event::dispatch($event);

        $user = $event->getDto();

        if(is_null($user)) {
            return null;
        }

        return new UserDto(
            id: $user->getId(),
            name: $user->getName(),
            userStatus: UserStatus::tryFrom($user->getUserStatus()->value)
        );
    }
}