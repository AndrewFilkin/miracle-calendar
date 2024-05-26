<?php

namespace Tests\Feature\Api\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApprovedUserTest extends BaseAdminTest
{
    use RefreshDatabase;

    public function test_user_already_approved()
    {
        $user = User::factory()->create(['is_approved' => true]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getAdminToken(),
        ])->patchJson('/api/admin/approved', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $response->assertStatus(409)
            ->assertJson(['message' => 'user already approved']);
    }

    public function test_successful_approval()
    {
        $user = User::factory()->create(['is_approved' => false]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getAdminToken(),
        ])->patchJson('/api/admin/approved', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'success approved user']);
    }

}
