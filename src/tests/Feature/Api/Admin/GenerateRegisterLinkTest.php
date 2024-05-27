<?php

namespace Tests\Feature\Api\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;

class GenerateRegisterLinkTest extends BaseAdminTest
{
    use RefreshDatabase;

    public function test_generate_register_link(): void
    {
        $this->generateRegisterLink();

        $this->response->assertStatus(201);

        $this->assertDatabaseHas('register_links', [
            'code' => $this->code,
        ]);
    }

}
