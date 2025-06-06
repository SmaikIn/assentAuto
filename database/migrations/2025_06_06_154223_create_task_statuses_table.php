<?php

use App\Models\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        TaskStatus::factory()->create([
            'name' => 'К выполнению',
            'slug' => 'waiting'
        ]);
        TaskStatus::factory()->create([
            'name' => 'В работе',
            'slug' => 'pending'
        ]);
        TaskStatus::factory()->create([
            'name' => 'Выполнена',
            'slug' => 'success'
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('task_statuses');
    }
};
