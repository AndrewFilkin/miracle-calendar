<?php

namespace Tests\Feature\Api\Admin;

use Tests\TestCase;

class BaseAdminTest extends TestCase
{

    public function getAdminToken()
    {
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
}
