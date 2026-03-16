<?php

namespace Tests\Feature\Api\V1;

use App\Models\Registro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistroApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Cada test de rutas privadas necesita un token real de Sanctum.
     *
     * Lo generamos aquí para no repetir código y para que el alumno vea
     * claramente que la API funciona con Bearer Token, no con sesión web.
     */
    private function authHeaders(): array
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
    }

    public function test_index_returns_registro_collection(): void
    {
        // Creamos datos de ejemplo para verificar que index devuelve una colección.
        Registro::create([
            'nombre' => 'Ana',
            'fecha' => '2026-03-01',
            'pasos' => 5000,
            'calorias' => 250,
            'estado' => 'Bien',
        ]);

        Registro::create([
            'nombre' => 'Luis',
            'fecha' => '2026-03-02',
            'pasos' => 7000,
            'calorias' => 300,
            'estado' => 'Normal',
        ]);

        $response = $this->getJson('/api/v1/registros', $this->authHeaders());

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    ['id', 'nombre', 'fecha', 'pasos', 'calorias', 'estado'],
                ],
            ]);
    }

    public function test_show_returns_single_registro(): void
    {
        // show debe devolver un único elemento y respetar la estructura del Resource.
        $registro = Registro::create([
            'nombre' => 'Pedro',
            'fecha' => '2026-03-03',
            'pasos' => 8000,
            'calorias' => 350,
            'estado' => 'Mal',
        ]);

        $response = $this->getJson('/api/v1/registros/' . $registro->id, $this->authHeaders());

        $response->assertOk()
            ->assertJsonPath('data.id', $registro->id)
            ->assertJsonPath('data.nombre', 'Pedro')
            ->assertJsonPath('data.estado', 'Mal');
    }

    public function test_store_creates_registro_and_returns_201(): void
    {
        // Verificamos estándar REST: creación correcta => 201 Created.
        $payload = [
            'nombre' => 'Sofia',
            'fecha' => '2026-03-04',
            'pasos' => 6500,
            'calorias' => 280,
            'estado' => 'Bien',
        ];

        $response = $this->postJson('/api/v1/registros', $payload, $this->authHeaders());

        $response->assertCreated()
            ->assertJsonPath('data.nombre', 'Sofia')
            ->assertJsonPath('data.estado', 'Bien');

        $this->assertDatabaseHas('registros', $payload);
    }

    public function test_store_validation_failure_returns_422_with_readable_json(): void
    {
        // Enviar datos inválidos nos permite comprobar la respuesta didáctica de validación (422).
        $payload = [
            'nombre' => '',
            'fecha' => 'fecha-invalida',
            'pasos' => -1,
            'calorias' => 'texto',
            'estado' => 'otro',
        ];

        $response = $this->postJson('/api/v1/registros', $payload, $this->authHeaders());

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['nombre', 'fecha', 'pasos', 'calorias', 'estado'],
            ]);
    }

    public function test_update_modifies_registro(): void
    {
        // Probamos PATCH parcial: no hace falta reenviar todos los campos.
        $registro = Registro::create([
            'nombre' => 'Carlos',
            'fecha' => '2026-03-01',
            'pasos' => 4000,
            'calorias' => 200,
            'estado' => 'Normal',
        ]);

        $payload = [
            'pasos' => 9000,
            'estado' => 'Bien',
        ];

        $response = $this->patchJson('/api/v1/registros/' . $registro->id, $payload, $this->authHeaders());

        $response->assertOk()
            ->assertJsonPath('data.id', $registro->id)
            ->assertJsonPath('data.pasos', 9000)
            ->assertJsonPath('data.estado', 'Bien');

        $this->assertDatabaseHas('registros', [
            'id' => $registro->id,
            'pasos' => 9000,
            'estado' => 'Bien',
        ]);
    }

    public function test_destroy_deletes_registro_and_returns_204(): void
    {
        // El borrado correcto no debe devolver cuerpo: 204 No Content.
        $registro = Registro::create([
            'nombre' => 'Elena',
            'fecha' => '2026-03-05',
            'pasos' => 7500,
            'calorias' => 320,
            'estado' => 'Normal',
        ]);

        $response = $this->deleteJson('/api/v1/registros/' . $registro->id, [], $this->authHeaders());

        $response->assertNoContent();

        $this->assertDatabaseMissing('registros', [
            'id' => $registro->id,
        ]);
    }

    public function test_private_routes_return_401_without_token(): void
    {
        // Si no hay token, la API debe bloquear el acceso para cumplir AE5.3.
        $response = $this->getJson('/api/v1/registros');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
