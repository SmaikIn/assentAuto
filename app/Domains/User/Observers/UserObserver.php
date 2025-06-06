<?php

declare(strict_types=1);

namespace App\Domains\User\Observers;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Meilisearch\Client as Meilisearch;

class UserObserver implements ShouldQueue
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }

    public function created(User $user): void
    {
        $this->addOrUpdateDoc($user);
    }

    public function updated(User $user): void
    {
        $this->addOrUpdateDoc($user);
    }

    public function saved(User $user): void
    {
        $this->addOrUpdateDoc($user);
    }

    public function deleted(User $user): void
    {
        $this->meilisearch->getIndex('users')->deleteDocument($user->id);
    }

    private function addOrUpdateDoc(User $user): void
    {
        $data = $user->toArray();

        unset($data['status_id']);

        $data['status']['id'] = $user->status->id;
        $data['status']['name'] = $user->status->name;
        $data['status']['slug'] = $user->status->slug;
        $this->meilisearch->getIndex('users')->addDocuments($data);
    }
}
