<?php

namespace Tests\Feature\Api\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminLoginTest extends BaseAdminTest
{
    use RefreshDatabase;

    public function test_login_admin(): void
    {

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('wMZn5wfqPF67qrQ'),
            'role' => 'admin',
            'is_approved' => true,
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wMZn5wfqPF67qrQ',
        ]);

        $response->assertStatus(200);
    }
}
