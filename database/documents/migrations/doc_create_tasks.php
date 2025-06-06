<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');
        $client = new \Meilisearch\Client($host, $key);

        $client->createIndex('tasks', ['primaryKey' => 'id']);
        $client->index('tasks')->updateFilterableAttributes([
            'id',
            'title',
            'status',
            'users',
            'created_at',
            'updated_at',
        ]);
    }

    public function down(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');

        $client = new \Meilisearch\Client($host, $key);
        $client->deleteIndex('tasks');
    }
};
