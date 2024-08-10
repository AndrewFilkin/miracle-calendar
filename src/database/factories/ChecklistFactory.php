<?php

namespace Database\Factories;

use App\Models\Checklist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Checklist>
 */
class ChecklistFactory extends Factory
{

    protected $model = Checklist::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(300),
            'user_id' => fake()->numberBetween(1, 200),
            'task_id' => fake()->numberBetween(1, 400),
        ];
    }
}
