<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_the_login_api_returns_a_successful_response()
    {
        $response = $this->postJson('api/login', [
            'username' => 'me',
            'password' => 'salv1234'
        ]);

        $response->assertStatus(200);
    }

    public function test_the_login_api_returns_a_failed_response()
    {
        $response = $this->postJson('api/login', [
            'username' => 'me1',
            'password' => 'salv1234'
        ]);

        $response->assertStatus(401);
    }

    public function test_login_api_bans_after_5_failed_attempts()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('api/login', [
                'username' => 'me1',
                'password' => 'salv1234'
            ]);

            $response = $this->postJson('api/login', [
                'username' => 'me1',
                'password' => 'salv1234'
            ]);

            dd($response->json());
        }
    }
}
