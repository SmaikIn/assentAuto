<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),

            'task_status_id' => TaskStatus::inRandomOrder()->first()->id,
        ];
    }
}
