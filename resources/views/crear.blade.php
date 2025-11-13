{{-- 
    Archivo: crear.blade.php
    Descripción: Vista que muestra el formulario para registrar los datos físicos del usuario.
    Envia los datos al método "guardar" del RegistroController mediante una petición POST.
--}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar progreso físico</title>
    {{-- TailwindCSS (ya instalado en el proyecto mediante Vite) --}}
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col items-center p-8">

    <h1 class="text-3xl font-bold mb-6 text-blue-600">Formulario de Registro Físico</h1>

    {{-- 
        Mostrar errores de validación (si los hay).
        Laravel guarda los mensajes de error en la variable $errors.
        Se muestran en un recuadro rojo para mayor visibilidad.
    --}}
    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-4 rounded mb-6 w-96">
            <strong>⚠️ Por favor corrige los errores antes de continuar:</strong>
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 
        Formulario principal:
        - Usa el helper route() para dirigir la acción al método "guardar".
        - Incluye el token @csrf (seguridad frente a ataques CSRF).
    --}}
    <form action="{{ route('registro.guardar') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md w-96 space-y-4">
        @csrf

        {{-- Campo de fecha --}}
        <div>
            <label for="fecha" class="block font-semibold mb-1">Fecha:</label>
            <input type="date" id="fecha" name="fecha" class="w-full border rounded p-2" required>
        </div>

        {{-- Campo de pasos --}}
        <div>
            <label for="pasos" class="block font-semibold mb-1">Pasos realizados:</label>
            <input type="number" id="pasos" name="pasos" class="w-full border rounded p-2" min="0" required>
        </div>

        {{-- Campo de calorías --}}
        <div>
            <label for="calorias" class="block font-semibold mb-1">Calorías consumidas:</label>
            <input type="number" id="calorias" name="calorias" class="w-full border rounded p-2" min="0" required>
        </div>

        {{-- Selector de estado físico/emocional --}}
        <div>
            <label for="estado" class="block font-semibold mb-1">Estado físico/emocional:</label>
            <select id="estado" name="estado" class="w-full border rounded p-2" required>
                <option value="">Selecciona una opción</option>
                <option value="Bien">Bien</option>
                <option value="Normal">Normal</option>
                <option value="Mal">Mal</option>
            </select>
        </div>

        {{-- Botón para enviar los datos --}}
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar registro
        </button>
    </form>

    {{-- Enlace para ir a la página del historial --}}
    <a href="{{ route('registro.index') }}" class="text-blue-600 mt-6 hover:underline">
        Ver historial de registros
    </a>
</body>
</html>