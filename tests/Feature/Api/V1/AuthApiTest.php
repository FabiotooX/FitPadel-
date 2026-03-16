<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_token_with_valid_credentials(): void
    {
        // Definimos password en claro para simular login real del cliente externo.
        $password = 'password123';

        // El cast 'hashed' del modelo User la guarda cifrada automáticamente.
        $user = User::factory()->create([
            'email' => 'api-user@example.com',
            'password' => $password,
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'token_type',
                'access_token',
                'user' => ['id', 'name', 'email'],
            ]);
    }

    public function test_login_returns_401_with_invalid_credentials(): void
    {
        // Creamos usuario válido, pero luego enviamos password errónea.
        User::factory()->create([
            'email' => 'api-user@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'api-user@example.com',
            'password' => 'incorrecta',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Credenciales incorrectas.',
            ]);
    }
}
