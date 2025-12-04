<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- Título de la página que aparece en la pestaña del navegador -->
    <title>{{ __('View registration history') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    <!-- 
        Cargamos los estilos CSS generados por Vite.
        Vite es la herramienta moderna de Laravel para compilar y servir CSS/JS.
    -->
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900 flex flex-col items-center p-8">
<!-- 
    Clase Tailwind:
    - bg-gray-100 → fondo gris claro
    - text-gray-900 → texto negro
    - flex flex-col items-center → diseño flexible vertical centrado
    - p-8 → padding alrededor del contenido
-->

<!-- TÍTULO PRINCIPAL -->
<h1 class="text-3xl font-bold mb-6 text-green-600">
    {{ __('Physical Registration') }} {{ __('History') }}
</h1>
<!-- 
    Clase Tailwind:
    - text-3xl → tamaño de fuente grande
    - font-bold → fuente en negrita
    - mb-6 → margen inferior
    - text-green-600 → color verde
-->

<!-- MENSAJE DE ÉXITO -->
@if (session('success'))
    <div class="bg-green-200 text-green-800 p-4 rounded mb-6 w-96">
        {{ session('success') }}
    </div>
@endif
<!-- 
    session('success') → obtiene el mensaje de éxito almacenado temporalmente en la sesión
    bg-green-200 → fondo verde claro
    text-green-800 → texto verde oscuro
    p-4 → padding
    rounded → esquinas redondeadas
    mb-6 → margen inferior
    w-96 → ancho fijo de la caja
-->

<!-- COMPROBACIÓN DE REGISTROS -->
@if ($registros->count() > 0)
<!-- 
    $registros es la colección que envía el controlador
    Si tiene al menos un registro, mostramos la tabla
-->

    <!-- TABLA DE REGISTROS -->
    <table class="border-collapse border border-gray-300 bg-white shadow-md rounded-lg">
        <!-- 
            border-collapse → fusiona los bordes de las celdas
            border → borde de toda la tabla
            border-gray-300 → color gris
            bg-white → fondo blanco
            shadow-md → sombra
            rounded-lg → esquinas redondeadas
        -->
        
        <!-- ENCABEZADO -->
        <thead class="bg-blue-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">{{ __('Name') }}</th>
                <th class="border border-gray-300 px-4 py-2">{{ __('Date') }}</th>
                <th class="border border-gray-300 px-4 py-2">{{ __('Steps taken') }}</th>
                <th class="border border-gray-300 px-4 py-2">{{ __('Calories consumed') }}</th>
                <th class="border border-gray-300 px-4 py-2">{{ __('Physical/emotional state') }}</th>
            </tr>
        </thead>
        <!-- 
            Cada <th> es una columna
            px-4 → padding horizontal
            py-2 → padding vertical
        -->

        <!-- CUERPO DE LA TABLA -->
        <tbody>
            @foreach ($registros as $registro)
            <!-- 
                Recorremos cada registro de la base de datos
                $registro es un objeto Eloquent con campos: nombre, fecha, pasos, calorías, estado
            -->
                <tr class="hover:bg-gray-100">
                <!-- hover:bg-gray-100 → al pasar el cursor, la fila cambia a gris claro -->
                    <td class="border border-gray-300 px-4 py-2">{{ $registro->nombre }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $registro->fecha }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $registro->pasos }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $registro->calorias }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $registro->estado }}</td>
                    <!-- 
                        {{ $registro->campo }} → imprime el valor de ese campo del registro
                    -->
                </tr>
            @endforeach
        </tbody>
    </table>

@else
    <!-- MENSAJE ALTERNATIVO SI NO HAY REGISTROS -->
    <p class="text-gray-600 mt-4">{{ __('No records saved yet') }}</p>
    <!-- 
        text-gray-600 → texto gris
        mt-4 → margen superior
    -->
@endif

<!-- ENLACES DE NAVEGACIÓN -->
<div class="mt-6 flex gap-4">
    <!-- Nuevo registro (solo visible si estás autenticado) -->
    @auth
        <a href="{{ route('registro.crear') }}" class="text-blue-600 hover:underline">
            {{ __('New record') }}
        </a>
    @endauth
    <!-- Volver al inicio -->
    <a href="{{ route('home') }}" class="text-gray-600 hover:underline">
        {{ __('Back to home') }}
    </a>
    <!-- 
        route('nombre') → genera la URL de la ruta definida en web.php
        hover:underline → subraya el texto al pasar el cursor
        flex gap-4 → espacio horizontal entre los enlaces
    -->
</div>

</body>
</html>
