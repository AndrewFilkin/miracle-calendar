<?php

namespace Database\Seeders;

use App\Models\Checklist;
use App\Models\Comment;
use App\Models\File;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('wMZn5wfqPF67qrQ'),
            'role' => 'admin',
            'is_approved' => true,
        ]);

        User::factory(200)->create();
        Task::factory(400)->create();
        TaskUser::factory(400)->create();
        Comment::factory(1000)->create();
        Checklist::factory(1000)->create();
        File::factory(2000)->create();
    }
}
