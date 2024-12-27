<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_email_is_empty()
    {
        $data = [
            'email' => '',
            'password' => 'validpassword123',
            'device_name' => 'UNIT_TESTING',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => ['email'],
            ]);
    }

    public function test_email_format_is_invalid()
    {
        $data = [
            'email' => 'logitech',
            'password' => 'validpassword123',
            'device_name' => 'UNIT_TESTING',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => ['email'],
            ])
            ->assertJsonFragment([
                'email' => ['The email field must be a valid email address.'],
            ]);
    }

    public function test_email_not_found()
    {
        $data = [
            'email' => 'user@localhost',
            'password' => 'password',
            'device_name' => 'UNIT_TESTING',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => ['email'],
            ])
            ->assertJsonFragment([
                'email' => ['These credentials do not match our records.'],
            ]);
    }

    public function test_password_is_empty()
    {
        $data = [
            'email' => 'user@localhost',
            'password' => '',
            'device_name' => 'UNIT_TESTING',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => ['password'],
            ])
            ->assertJsonFragment([
                'password' => ['The password field is required.'],
            ]);
    }

    public function test_password_is_incorrect()
    {
        $data = [
            'email' => 'administrator@localhost',
            'password' => 'wrongPassword',
            'device_name' => 'UNIT_TESTING',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => ['email'],
            ])
            ->assertJsonFragment([
                'email' => ['These credentials do not match our records.'],
            ]);
    }

    public function test_login_successful_returns_sanctum_token()
    {
        $data = [
            'email' => 'administrator@localhost',
            'password' => 'password',
            'device_name' => 'UNIT_TESTING',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['token'],
            ]);

        $token = $response->json('data.token');

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }
}
