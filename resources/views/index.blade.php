{{-- 
    Archivo: index.blade.php
    Descripción: Muestra una tabla con los registros físicos guardados en registros.csv.
    Si no existen registros, muestra un mensaje informativo.
--}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Registros</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col items-center p-8">

    <h1 class="text-3xl font-bold mb-6 text-green-600">Historial de Registros Físicos</h1>

    {{-- 
        Mostrar el mensaje de éxito (flash message) al guardar un nuevo registro.
        Este mensaje se genera desde el controlador al hacer redirect con with('success', ...)
    --}}
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-6 w-96">
            {{ session('success') }}
        </div>
    @endif

    {{-- 
        Estructura condicional con Blade:
        Si hay registros, se muestran en tabla; si no, se indica que está vacío.
    --}}
    @if (count($registros) > 0)
        <table class="border-collapse border border-gray-300 bg-white shadow-md rounded-lg">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Fecha</th>
                    <th class="border border-gray-300 px-4 py-2">Pasos</th>
                    <th class="border border-gray-300 px-4 py-2">Calorías</th>
                    <th class="border border-gray-300 px-4 py-2">Estado</th>
                </tr>
            </thead>
            <tbody>
                {{-- 
                    Recorremos el array $registros usando @foreach.
                    Cada elemento del CSV se muestra como una fila de la tabla.
                --}}
                @foreach ($registros as $registro)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $registro['fecha'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $registro['pasos'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $registro['calorias'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $registro['estado'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600 mt-4">No hay registros guardados todavía.</p>
    @endif

    {{-- Enlaces para navegar --}}
    <div class="mt-6 flex gap-4">
        <a href="{{ route('registro.crear') }}" class="text-blue-600 hover:underline">Nuevo registro</a>
        <a href="{{ route('home') }}" class="text-gray-600 hover:underline">Volver a inicio</a>
    </div>

</body>
</html>