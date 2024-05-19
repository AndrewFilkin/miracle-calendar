<?php

namespace Database\Factories;

use App\Models\TaskUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskUser>
 */
class TaskUserFactory extends Factory
{

    protected $model = TaskUser::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 200),
            'task_id' => fake()->numberBetween(1, 400)
        ];
    }
}
