<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_then_logout()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->from('/login')
            ->post('/login', [
                'email' => 'test@example.com',
                'password' => 'secret123',
            ])
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

        $this->get('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
