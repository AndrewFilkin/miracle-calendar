<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Database\Factories\CreateAdminFactory;
use Database\Factories\UserFactory;
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
            'avatar' => "admin.jpg",
        ]);

        User::factory(200)->create();
        Project::factory(200)->create();


    }
}
