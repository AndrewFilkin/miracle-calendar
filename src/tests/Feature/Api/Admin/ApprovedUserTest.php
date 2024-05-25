<?php

namespace Tests\Feature\Api\Admin;

use Tests\TestCase;
use App\Models\User;

class ApprovedUserTest extends BaseAdminTest
{

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

//    public function test_successful_approval()
//    {
//        $user = User::factory()->create(['is_approved' => false]);
//
//        $response = $this->postJson('/api/approved', ['email' => $user->email]);
//
//        $response->assertStatus(200)
//            ->assertJson(['message' => 'success approved user']);
//
//        $this->assertDatabaseHas('users', [
//            'email' => $user->email,
//            'is_approved' => true,
//        ]);
//    }
//
//    public function test_user_not_found()
//    {
//        $response = $this->postJson('/api/approved', ['email' => 'nonexistent@example.com']);
//
//        $response->assertStatus(409)
//            ->assertJson(['message' => 'something wrong']);
//    }

}
