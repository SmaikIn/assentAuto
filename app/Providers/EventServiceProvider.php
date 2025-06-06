<?php

namespace App\Providers;

use App\Domains\Task\Events\FindUserByIdEvent;
use App\Domains\Task\Events\TaskCreatedEvent;
use App\Domains\Task\Listeners\TaskCreatedListener;
use App\Domains\Task\Observers\TaskObserver;
use App\Domains\User\Listeners\FindUserByIdListener;
use App\Domains\User\Observers\UserObserver;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        FindUserByIdEvent::class => [
            FindUserByIdListener::class,
        ],
        TaskCreatedEvent::class => [
            TaskCreatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Task::observe(TaskObserver::class);
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
