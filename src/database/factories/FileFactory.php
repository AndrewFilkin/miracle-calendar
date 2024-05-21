<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment_id' => fake()->numberBetween(1, 1000),
            'user_id' => fake()->numberBetween(1, 200),
            'file_name_in_storage' => fake()->filePath(),
            'original_name' => fake()->filePath(),
        ];
    }
}
