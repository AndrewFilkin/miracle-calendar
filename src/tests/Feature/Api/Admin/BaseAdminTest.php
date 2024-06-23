<?php

namespace Tests\Feature\Api\Admin;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class BaseAdminTest extends TestCase
{
    protected $response;
    protected $code;

    protected function createAdmin()
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('wMZn5wfqPF67qrQ'),
            'role' => 'admin',
            'is_approved' => true,
        ]);
    }

    protected function getAdminToken()
    {
        $this->createAdmin();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wMZn5wfqPF67qrQ',
        ]);

        $responseData = $response->decodeResponseJson();
        $accessToken = $responseData['access_token'];

        return $accessToken;
    }

    public function generateRegisterLink() {

        $this->response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getAdminToken(),
        ])->post('/api/admin/generate-register-link');

        $this->code = $this->response->getOriginalContent()['link_created'];
    }

}
