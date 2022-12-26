<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_register()
    {
        $payload = [
            'name' => 'user',
            'email' => 'user@email.com',
            'password' => 'password',
            'confirm_password' => 'password'
        ];

        $response = $this->post(route('api.auth.register'), $payload);

        $this->assertEquals(1, User::count());
        $response->assertOk();
        $response->assertSee('success');
    }

    public function test_user_can_authenticate()
    {
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->post(route('api.auth.authenticate'), $payload);

        $response->assertOk();
        $response->assertSee('success');
    }
}
