<?php

namespace Tests\Feature\Api\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminLoginTest extends BaseAdminTest
{
    public function test_login_admin(): void
    {
        DB::beginTransaction();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('wMZn5wfqPF67qrQ'),
            'role' => 'admin',
            'is_approved' => true,
            'avatar' => "admin.jpg",
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wMZn5wfqPF67qrQ',
        ]);

        $response->assertStatus(200);

        DB::rollBack();
    }
}
