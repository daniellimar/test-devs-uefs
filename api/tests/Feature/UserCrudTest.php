<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_users_authenticated()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson('/api/users');

        $response->assertStatus(200);
    }

    public function test_create_user_authenticated()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)->postJson('/api/users', [
            'name' => 'Novo Usuário',
            'email' => fake()->unique()->userName() . '@' . config('corporate.domain'),
            'password' => '12345678',
        ]);

        $response->assertStatus(201);
    }
}
