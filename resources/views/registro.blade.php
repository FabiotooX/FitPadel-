<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Declaramos el tipo de documento y el idioma -->
    <meta charset="UTF-8"> <!-- Define la codificación de caracteres como UTF-8 -->
    <title>Registro Físico</title> <!-- Título que aparece en la pestaña del navegador -->

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    <!-- CARGA DE ESTILOS CON VITE -->
    <!--
        @vite('resources/css/app.css') carga el CSS compilado por Vite.
        Laravel Vite permite compilar Tailwind CSS y JS modernos de forma rápida.
        Esto reemplaza los tradicionales <link rel="stylesheet">.
    -->
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900 flex flex-col items-center p-8">
    <!--
        Body:
        - bg-gray-100 → fondo gris claro
        - text-gray-900 → texto negro oscuro
        - flex flex-col → disposición en columna con flexbox
        - items-center → centra horizontalmente los elementos
        - p-8 → padding de 2rem alrededor
    -->

    <!-- TÍTULO PRINCIPAL -->
    <h1 class="text-3xl font-bold mb-6 text-blue-600">
        {{ __('Physical Registration') }}
    </h1>
    <!--
        - text-3xl → tamaño de letra grande (3 veces el tamaño base)
        - font-bold → negrita
        - mb-6 → margen inferior para separar del siguiente bloque
        - text-blue-600 → color azul
    -->

    <!-- BLOQUE DE ERRORES DE VALIDACIÓN -->
    @if ($errors->any())
        <!--
            Se muestra solo si Laravel detecta errores de validación
            al enviar el formulario.
        -->
        <div class="bg-red-200 text-red-800 p-4 rounded mb-6 w-96">
            <strong>{{ __('Please correct the errors') }}:</strong>
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <!--
                        Recorremos todos los errores de validación
                        $errors->all() devuelve un array de mensajes
                    -->
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!--
        bg-red-200 → fondo rojo claro
        text-red-800 → texto rojo oscuro
        p-4 → padding dentro del div
        rounded → bordes redondeados
        mb-6 → margen inferior
        w-96 → ancho fijo de 24rem
        list-disc → lista con viñetas
        pl-6 → padding-left para separar viñetas
    -->

    <!-- BLOQUE DE MENSAJES DE ÉXITO -->
    @if (session('success'))
        <!--
            Se muestra si el controlador ha guardado un mensaje de éxito en la sesión
            session('success') obtiene ese mensaje temporal
        -->
        <div class="bg-green-200 text-green-800 p-4 rounded mb-6 w-96">
            {{ session('success') }} <!-- Mostramos el mensaje -->
        </div>
    @endif

    <!-- BLOQUE DE MENSAJES DE ERROR DEL CONTROLADOR -->
    @if (session('error'))
        <!--
            Se muestra si el controlador guarda un mensaje de error en la sesión
            por ejemplo si hay problema guardando el CSV
        -->
        <div class="bg-red-200 text-red-800 p-4 rounded mb-6 w-96">
            {{ session('error') }} <!-- Mostramos el mensaje -->
        </div>
    @endif

    <!-- FORMULARIO PRINCIPAL -->
    <form action="{{ route('registro.guardar') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md w-96 space-y-4">
        <!--
            action="{{ route('registro.guardar') }}" → define la ruta que procesará el formulario
            method="POST" → método HTTP usado para enviar los datos
            class="..." → clases de Tailwind para estilo:
                - bg-white → fondo blanco
                - p-6 → padding interno de 1.5rem
                - rounded-lg → bordes redondeados
                - shadow-md → sombra
                - w-96 → ancho fijo
                - space-y-4 → espacio vertical entre elementos del formulario
        -->

        @csrf <!--
            Token de seguridad CSRF (Cross-Site Request Forgery)
            Laravel lo exige para todos los formularios POST
        -->

        <!-- CAMPO NOMBRE -->
        <div>
            <label for="nombre" class="block font-semibold mb-1">{{ __('Name') }}:</label>
            <!--
                for="nombre" → vincula la etiqueta con el input correspondiente
                block → ocupa toda la línea
                font-semibold → letra seminegrita
                mb-1 → margen inferior
            -->
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" 
                   class="w-full border rounded p-2" maxlength="50" required>
            <!--
                type="text" → campo de texto
                value="{{ old('nombre') }}" → mantiene el valor previo si hay error
                w-full → ancho completo
                border → borde alrededor
                rounded → bordes redondeados
                p-2 → padding interno
                maxlength="50" → máximo 50 caracteres
                required → campo obligatorio
            -->
        </div>

        <!-- CAMPO FECHA -->
        <div>
            <label for="fecha" class="block font-semibold mb-1">{{ __('Date') }}:</label>
            <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" 
                   class="w-full border rounded p-2" required>
            <!--
                type="date" → muestra un selector de fecha
                value="{{ old('fecha') }}" → mantiene el valor ingresado si hay error
            -->
        </div>

        <!-- CAMPO PASOS -->
        <div>
            <label for="pasos" class="block font-semibold mb-1">{{ __('Steps taken') }}:</label>
            <input type="number" id="pasos" name="pasos" value="{{ old('pasos') }}" 
                   class="w-full border rounded p-2" min="0" required>
            <!--
                type="number" → campo numérico
                min="0" → no permite números negativos
            -->
        </div>

        <!-- CAMPO CALORÍAS -->
        <div>
            <label for="calorias" class="block font-semibold mb-1">{{ __('Calories consumed') }}:</label>
            <input type="number" id="calorias" name="calorias" value="{{ old('calorias') }}" 
                   class="w-full border rounded p-2" min="0" required>
            <!--
                Igual que el campo pasos, solo valores positivos
            -->
        </div>

        <!-- CAMPO ESTADO -->
        <div>
            <!--
                <label> → etiqueta que describe el campo.
                for="estado" → vincula el label con el <select> que tiene id="estado".
                Esto permite que si el usuario hace clic en el texto "Estado físico/emocional",
                se active automáticamente el selector.
                class="block font-semibold mb-1" → clases de Tailwind:
                    - block → el label ocupa toda la línea
                    - font-semibold → letra seminegrita
                    - mb-1 → margen inferior para separar del select
            -->
            <label for="estado" class="block font-semibold mb-1">{{ __('Physical/emotional state') }}:</label>

            <!--
                <select> → crea un menú desplegable para seleccionar una opción
                id="estado" → identifica el select en el HTML y lo vincula con el label
                name="estado" → nombre del campo que se enviará al servidor
                class="w-full border rounded p-2" → estilo Tailwind:
                    - w-full → ancho completo del contenedor
                    - border → agrega un borde alrededor
                    - rounded → bordes redondeados
                    - p-2 → padding interno
                required → obliga al usuario a seleccionar una opción antes de enviar el formulario
            -->
            <select id="estado" name="estado" class="w-full border rounded p-2" required>

                <!--
                    Opción inicial vacía
                    value="" → valor vacío, sirve como placeholder
                    Esto fuerza al usuario a elegir un valor real
                -->
                <option value="">{{ __('Select an option') }}</option>

                <!--
                    Cada opción tiene un value que se enviará al servidor al enviar el formulario.
                    La sintaxis Blade {{ old('estado') == 'Bien' ? 'selected' : '' }} sirve para:
                    1) old('estado') → obtiene el valor que el usuario había seleccionado previamente si hubo un error de validación
                    2) Comparar con el valor actual de la opción (por ejemplo 'Bien')
                    3) Si coinciden, se agrega el atributo 'selected' a esa opción
                    → Esto hace que cuando el formulario se recargue por un error, el usuario vea su elección anterior seleccionada
                    4) Si no coincide, no se agrega nada ('').
                -->
                <option value="Bien" {{ old('estado') == 'Bien' ? 'selected' : '' }}>{{ __('Well') }}</option>
                <option value="Normal" {{ old('estado') == 'Normal' ? 'selected' : '' }}>{{ __('Normal') }}</option>
                <option value="Mal" {{ old('estado') == 'Mal' ? 'selected' : '' }}>{{ __('Bad') }}</option>
            </select>

            <!--
                Resumen del comportamiento:
                - El usuario ve un desplegable con tres opciones: Bien, Normal, Mal
                - Si envía el formulario y hay un error de validación, la opción previamente elegida se mantiene
                - Esto evita que el usuario tenga que volver a seleccionar su estado
            -->
        </div>


        <!-- BOTÓN DE ENVÍO -->
        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full transition duration-300">
            {{ __('Save record') }}
        </button>
        <!--
            bg-blue-600 → fondo azul
            text-white → texto blanco
            px-4 py-2 → padding horizontal y vertical
            rounded → bordes redondeados
            hover:bg-blue-700 → cambio de color al pasar el ratón
            w-full → ocupa todo el ancho del formulario
            transition duration-300 → transición suave de 0.3s
        -->
    </form>

    <!-- ENLACES DE NAVEGACIÓN -->
    <div class="flex flex-col items-center mt-6 space-y-2">
        <a href="{{ route('registro.index') }}" class="text-blue-600 hover:underline">{{ __('View registration history') }}</a>
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 hover:underline">{{ __('Back to home') }}</a>
    </div>
    <!--
        - flex flex-col items-center → enlaces en columna centrados
        - mt-6 → margen superior
        - space-y-2 → separación vertical entre enlaces
        - route('registro.index') → genera la URL del historial
        - route('home') → genera la URL de inicio
    -->

</body>
</html>
