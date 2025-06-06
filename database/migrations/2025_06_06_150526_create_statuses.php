<?php

use App\Models\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Status::factory()->create([
            'name' => 'Работает',
            'slug' => 'working',
        ]);
        Status::factory()->create([
            'name' => 'В отпуске',
            'slug' => 'vacation',
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('user_statuses');
    }
};
