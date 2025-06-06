<?php

declare(strict_types=1);

namespace App\Domains\User\Repositories\Database;

use App\Domains\User\Dto\UserDto;
use App\Domains\User\Enum\UserStatus;
use App\Domains\User\ValueObject\Email;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Throwable;

final class UserRepository
{

    /**
     * @param  UserDto  $registerDto
     * @return UserDto
     * @throws Throwable
     */
    public function create(UserDto $registerDto): UserDto
    {
        $dbUser = new User;

        $dbUser->name = $registerDto->getName();
        $dbUser->email = $registerDto->getEmail()->getValue();
        $dbUser->password = $registerDto->getPassword()->getHashValue();

        $dbUser->status = \App\Models\Status::where('slug', UserStatus::Working->value)->first()->id;

        $dbUser->saveOrFail();
        $dbUser->refresh();

        return $this->_formatDto($dbUser);
    }

    /**
     * @param  UserDto  $dto
     * @return UserDto
     * @throws Throwable
     */
    public function update(UserDto $dto): UserDto
    {
        $dbUser = User::where('id', $dto->getId())->firstOrFail();

        $dbUser->name = $dto->getName();
        $dbUser->email = $dto->getEmail()->getValue();
        $dbUser->status_id = Status::where('slug', $dto->getUserStatus()->value)->first()->id;

        $dbUser->saveOrFail();
        $dbUser->refresh();

        return $this->_formatDto($dbUser);
    }

    /**
     * @param  int  $userId
     * @return bool|null
     * @throws Throwable
     */
    public function deleteById(int $userId): ?bool
    {
        return User::where('id', $userId)->firstOrFail()->deleteOrFail();
    }

    private function _formatDto(User $user): UserDto
    {
        return new UserDto(
            id: $user->id,
            name: $user->name,
            email: Email::create($user->email),
            userStatus: UserStatus::tryFrom($user->status->slug),
            password: null,
            createdAt: Carbon::parse($user->created_at),
            updatedAt: Carbon::parse($user->updated_at),
        );
    }


}