<?php

namespace Tests\Feature\Api\Admin;

use App\Models\RegisterLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class GenerateRegisterLinkTest extends BaseAdminTest
{
    use RefreshDatabase;

    public $response;
    public $code;

    public function test_generate_register_link(): void
    {
        $this->generateRegisterLink();

        $this->response->assertStatus(201);

        $this->assertDatabaseHas('register_links', [
            'code' => $this->code,
        ]);
    }

    public function generateRegisterLink() {

        $this->response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getAdminToken(),
        ])->post('/api/admin/generate-register-link');

        $this->code = $this->response->getOriginalContent()['link_created: '];
    }
}
