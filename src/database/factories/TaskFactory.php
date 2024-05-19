<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 years', 'now');
        $endDate = fake()->dateTimeBetween($startDate, '+1 years');

        return [
            'project_id' => fake()->numberBetween(1, 200),
            'name' => fake()->slug,
            'description' => fake()->text(200),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_completed' => fake()->boolean,
            'creator_id' => fake()->numberBetween(1, 200),
        ];
    }
}
