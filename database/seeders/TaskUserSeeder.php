<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskUserSeeder extends Seeder
{
    public function run()
    {
        foreach (Task::all() as $task) {
            foreach (range(1, 3) as $index) {
                $user = User::inRandomOrder()->first();
                $task->users()->attach($user);
            }
        }
    }
}
