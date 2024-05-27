<?php

namespace Tests\Feature\Api\User;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthTest extends BaseUserTest
{
    use RefreshDatabase;

    public function test_user_registration(): void
    {
        $this->generateRegisterLink();
        $code = $this->code;

        $password = fake()->password;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('/api/register/'. $code, [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
            'role' => null,
            'position' => fake()->randomElement(['Учитель физики', 'Учитель физкультуры', 'Зауч', 'Учитель математики']),
            'vk_link' => 'https://vk.com/'. Str::random(7),
            'avatar' => null,
            'is_approved' => false,
        ]);

        dump($response);

        $response->assertStatus(201)
            ->assertJson(['message' => 'register success']);
    }
}
