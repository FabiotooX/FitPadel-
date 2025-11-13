<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Este controlador gestiona los "Registros Físicos" del proyecto FitPadel+.
// Incluye tres funciones principales:
// - crear(): muestra el formulario al usuario.
// - guardar(): valida y guarda los datos en un archivo CSV.
// - index(): muestra todos los registros en una tabla.

class RegistroController extends Controller
{
    // Método crear()
    // Muestra el formulario de registro físico (fecha, pasos, calorías, estado).
    // Retorna una vista Blade llamada "create.blade.php" ubicada en resources/views/
    public function crear()
    {
        return view('crear');
    }

    // Método guardar()
    // Recibe los datos del formulario, los valida y los guarda en un archivo CSV.
    // Luego redirige al listado de registros con un mensaje de confirmación.
    public function guardar(Request $request)
    {
        // Validación de los campos: evita datos vacíos o incorrectos.
        $validated = $request->validate([
            'fecha' => 'required|date',
            'pasos' => 'required|integer|min:0',
            'calorias' => 'required|integer|min:0',
            'estado' => 'required|in:Bien,Normal,Mal',
        ]);

        // Convertimos los datos en una línea CSV (separada por comas)
        $linea = implode(',', [
            $validated['fecha'],
            $validated['pasos'],
            $validated['calorias'],
            $validated['estado'],
        ]) . PHP_EOL; // PHP_EOL añade un salto de línea según el sistema operativo

        // Guardamos la línea en el archivo "registros.csv" dentro de storage/app
        Storage::append('registros.csv', $linea);

        // Redirigimos al historial de registros con un mensaje de éxito
        return redirect()->route('registro.index')->with('success', 'Registro guardado correctamente.');
    }

    // Método index()
    // Lee el archivo CSV y muestra todos los registros en una tabla.
    public function index()
    {
        $registros = []; // Array donde guardaremos los datos del CSV
        $path = storage_path('app/registros.csv'); // Ruta completa del archivo CSV

        // Si el archivo existe, lo abrimos y leemos cada línea
        if (file_exists($path)) {
            $file = fopen($path, 'r'); // Abrimos el archivo en modo lectura

            // Cada línea se convierte en un array con fgetcsv()
            while (($data = fgetcsv($file)) !== false) {
                $registros[] = [
                    'fecha' => $data[0],
                    'pasos' => $data[1],
                    'calorias' => $data[2],
                    'estado' => $data[3],
                ];
            }

            fclose($file); // Cerramos el archivo tras leerlo
        }

        // Pasamos el array $registros a la vista "index.blade.php"
        return view('index', compact('registros'));
    }
}