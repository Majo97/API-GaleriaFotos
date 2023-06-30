<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegister()
    {
        $response = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'Registered successfully',
            'data' => [

            ]
        ]);
    }

    public function testLogin()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/api/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'code',
            'message',
            'data' => [
                'token',
            ]
        ]);
    }

    public function testForgotPassword()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com'
        ]);

        $response = $this->post('/api/forgot-password', [
            'email' => 'johndoe@example.com'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'A password reset link has been sent to your email.'
        ]);
    }

     
}
