<?php
/**
 * Script de Pruebas Automáticas (Test Suite)
 * -----------------------------------------
 * Este archivo no es parte de la aplicación Laravel, sino una herramienta
 * para verificar que nuestra API funciona correctamente.
 * 
 * Uso: php verify_full.php
 * Meta: Comprobar el CRUD completo y las validaciones.
 */

// URL base de nuestra API (ajustar si se usa otro puerto o IP)
$baseUrl = 'http://localhost:8000/api/v1/registros';

/**
 * Función auxiliar para hacer peticiones HTTP usando CURL.
 * Simula lo que haría un cliente como Postman o una App móvil.
 */
function call($method, $url, $data = null) {
    global $baseUrl;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    // Indicamos que enviamos y esperamos JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return ['code' => $info['http_code'], 'body' => $res]; // Devolvemos código HTTP y cuerpo
}

echo "--- INICIO DE LAS PRUEBAS AUTOMATIZADAS ---\n\n";

echo "1. Listado (GET)\n";
echo "   Meta: Obtener código 200 OK y la lista de registros.\n";
$res = call('GET', $baseUrl);
echo "   Resultado: " . $res['code'] . " (Esperado 200)\n\n";

echo "2. Crear con Error (POST)\n";
echo "   Meta: Enviar datos vacíos y esperar código 422 (Unprocessable Entity) por validación.\n";
$res = call('POST', $baseUrl, ['nombre' => '']);
echo "   Resultado: " . $res['code'] . " (Esperado 422)\n\n";

echo "3. Crear Correctamente (POST)\n";
echo "   Meta: Crear un registro nuevo y recibir 201 Created.\n";
$res = call('POST', $baseUrl, [
    'nombre' => 'Test Flow',
    'fecha' => '2024-02-01',
    'pasos' => 1500,
    'calorias' => 300,
    'estado' => 'activo'
]);
echo "   Resultado: " . $res['code'] . " (Esperado 201)\n";
$json = json_decode($res['body'], true);
$id = $json['data']['id'] ?? null;

if ($id) {
    echo "   >> ID Creado: $id\n\n";
    
    echo "4. Ver Individual (GET)\n";
    echo "   Meta: Ver el registro que acabamos de crear.\n";
    $res = call('GET', "$baseUrl/$id");
    echo "   Resultado: " . $res['code'] . " (Esperado 200)\n\n";
    
    echo "5. Actualizar (PUT)\n";
    echo "   Meta: Modificar datos y recibir 200 OK.\n";
    $res = call('PUT', "$baseUrl/$id", ['nombre' => 'Updated Flow', 'pasos' => 2000]);
    echo "   Resultado: " . $res['code'] . " (Esperado 200)\n\n";
    
    echo "6. Eliminar (DELETE)\n";
    echo "   Meta: Borrar el registro y recibir 204 No Content.\n";
    $res = call('DELETE', "$baseUrl/$id");
    echo "   Resultado: " . $res['code'] . " (Esperado 204)\n\n";
} else {
    echo "   [!] Error crítico: No se pudo crear el registro, se cancelan las pruebas dependientes.\n";
}

echo "--- FIN DE LAS PRUEBAS ---\n";
