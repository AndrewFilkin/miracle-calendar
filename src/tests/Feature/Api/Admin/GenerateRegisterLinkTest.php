<?php

namespace Tests\Feature\Api\Admin;

use App\Models\RegisterLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class GenerateRegisterLinkTest extends BaseAdminTest
{
    use RefreshDatabase;

    public function test_generate_register_link(): void
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getAdminToken(),
        ])->post('/api/admin/generate-register-link');

        $response->assertStatus(201);

        $code = $response->getOriginalContent()['link created: '];

        $this->assertDatabaseHas('register_links', [
            'code' => $code,
        ]);
    }
}
