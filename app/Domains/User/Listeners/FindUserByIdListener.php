<?php

namespace App\Domains\User\Listeners;

use App\Domains\Task\Events\FindUserByIdEvent;
use App\Domains\User\Service\UserService;

readonly class FindUserByIdListener
{
    public function __construct(
        private UserService $userService
    ) {
    }

    public function handle(FindUserByIdEvent $event): void
    {
        try {
            $user = $this->userService->find($event->getUserId());
        } catch (\Throwable $throwable) {
            return;
        }

        $event->setDto($user);
    }
}
