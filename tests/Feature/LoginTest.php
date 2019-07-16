<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use ___PHPSTORM_HELPERS\object;

class LoginTest extends TestCase
{
    /**
     * Checks that login contains the email and password.
     *
     * @return void
     */
    public function testRequiresEmailAndPassword()
    {
        $response = $this->post('api/login');

        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'access_token',
                'token_type',
                'expires_in',
            ]);

    }
}
