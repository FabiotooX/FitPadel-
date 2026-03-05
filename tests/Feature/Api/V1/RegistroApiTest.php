<?php

namespace Tests\Feature\Api\V1;

use App\Models\Registro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistroApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_registro_collection(): void
    {
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

        $response = $this->getJson('/api/v1/registros');

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
        $registro = Registro::create([
            'nombre' => 'Pedro',
            'fecha' => '2026-03-03',
            'pasos' => 8000,
            'calorias' => 350,
            'estado' => 'Mal',
        ]);

        $response = $this->getJson('/api/v1/registros/' . $registro->id);

        $response->assertOk()
            ->assertJsonPath('data.id', $registro->id)
            ->assertJsonPath('data.nombre', 'Pedro')
            ->assertJsonPath('data.estado', 'Mal');
    }

    public function test_store_creates_registro_and_returns_201(): void
    {
        $payload = [
            'nombre' => 'Sofia',
            'fecha' => '2026-03-04',
            'pasos' => 6500,
            'calorias' => 280,
            'estado' => 'Bien',
        ];

        $response = $this->postJson('/api/v1/registros', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.nombre', 'Sofia')
            ->assertJsonPath('data.estado', 'Bien');

        $this->assertDatabaseHas('registros', $payload);
    }

    public function test_store_validation_failure_returns_422_with_readable_json(): void
    {
        $payload = [
            'nombre' => '',
            'fecha' => 'fecha-invalida',
            'pasos' => -1,
            'calorias' => 'texto',
            'estado' => 'otro',
        ];

        $response = $this->postJson('/api/v1/registros', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['nombre', 'fecha', 'pasos', 'calorias', 'estado'],
            ]);
    }

    public function test_update_modifies_registro(): void
    {
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

        $response = $this->patchJson('/api/v1/registros/' . $registro->id, $payload);

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
        $registro = Registro::create([
            'nombre' => 'Elena',
            'fecha' => '2026-03-05',
            'pasos' => 7500,
            'calorias' => 320,
            'estado' => 'Normal',
        ]);

        $response = $this->deleteJson('/api/v1/registros/' . $registro->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('registros', [
            'id' => $registro->id,
        ]);
    }
}
