<?php

namespace Tests\Feature\Api\Admin;

class AdminLoginTest extends BaseAdminTest
{
    public function test_login_admin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wMZn5wfqPF67qrQ',
        ]);

        $response->assertStatus(200);
    }
}
