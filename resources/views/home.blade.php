<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- 
        La metaetiqueta viewport permite que el diseño sea adaptable a móviles, tabletas y pantallas grandes.
        Es fundamental para hacer una web "responsive", evitando que los elementos se vean demasiado pequeños o desbordados.
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título que aparece en la pestaña del navegador -->
    <title>FitPadel+ | Padel, Fitness y Bienestar</title>

    <!-- 
        Cargamos los estilos de Tailwind CSS compilados con Vite.
        @vite('resources/css/app.css') genera automáticamente las rutas correctas a los archivos CSS/JS.
    -->
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 font-sans">
<!-- 
    bg-gray-50 → fondo gris muy claro
    font-sans → fuente sans-serif para todo el contenido
-->

    {{-- 
        VISTA PRINCIPAL (home.blade.php)
        - Página de inicio de FitPadel+.
        - Contiene: header/menú, hero (mensaje principal), secciones informativas y footer.
    --}}

    <!-- ENCABEZADO / MENÚ DE NAVEGACIÓN -->
    <header class="bg-white shadow-md">
        <!-- bg-white → fondo blanco, shadow-md → sombra para darle relieve -->
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <!-- 
                container mx-auto → centra el contenido horizontalmente
                px-6 py-3 → padding horizontal y vertical
                flex justify-between items-center → menú flexible, elementos separados y alineados verticalmente
            -->

            <!-- Nombre / Logo de la app -->
            <a href="#" class="text-2xl font-bold text-indigo-600">FitPadel+</a>
            <!-- text-2xl → tamaño de fuente grande, font-bold → negrita, text-indigo-600 → color azul índigo -->

            <!-- Enlaces del menú -->
            <div class="space-x-4 flex items-center">
                <!-- space-x-4 → espacio horizontal entre cada enlace -->
                <!-- Botón para ir al login o dashboard -->
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                        Dashboard
                    </a>
                    
                    <!-- Botón de Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300 font-semibold flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                        Login
                    </a>
                @endauth

                <!-- Botón para ir al formulario de registro físico -->
                <a href="{{ route('registro.crear') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                    Añadir registro
                </a>
                <!-- 
                    bg-indigo-600 → fondo azul
                    text-white → texto blanco
                    px-4 py-2 → padding
                    rounded-lg → esquinas redondeadas
                    hover:bg-indigo-700 → cambia el color al pasar el cursor
                    transition duration-300 → animación suave de cambio de color
                -->
            </div>
        </nav>
    </header>

    <!-- SECCIÓN PRINCIPAL (Hero Section) -->
    <main class="container mx-auto px-6 py-16">
        <!-- py-16 → padding vertical grande para separar del header -->

        <div class="flex flex-col lg:flex-row items-center justify-between">
        <!-- 
            flex flex-col → en móviles los elementos se apilan verticalmente
            lg:flex-row → en pantallas grandes se colocan horizontalmente
            items-center → centra verticalmente
            justify-between → espacio máximo entre bloques de texto e imagen
        -->

            <!-- Bloque de texto principal -->
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <!-- lg:w-1/2 → ocupa la mitad del ancho en pantallas grandes -->
                <!-- mb-10 → margen inferior en móviles -->
                
                <h1 class="text-5xl font-extrabold text-gray-900 leading-tight">
                    Eleva tu Juego con <span class="text-indigo-600">FitPadel+</span>
                </h1>
                <!-- 
                    text-5xl → muy grande
                    font-extrabold → negrita extra
                    text-gray-900 → texto casi negro
                    leading-tight → espacio entre líneas ajustado
                    <span> → permite cambiar color solo a parte del texto
                -->

                <p class="mt-4 text-xl text-gray-600">
                    La aplicación que combina <strong>seguimiento físico/emocional</strong>,
                    <strong>entrenamiento de pádel</strong> y <strong>rutinas personalizadas</strong> 
                    para un bienestar completo.
                </p>
                <!-- mt-4 → margen superior, text-xl → texto grande, text-gray-600 → color gris -->

                <!-- Botones de llamada a la acción -->
                <div class="mt-8 space-x-4">
                    <!-- mt-8 → separación del párrafo, space-x-4 → espacio entre botones -->

                    <a href="#" 
                       class="bg-indigo-600 text-white text-lg font-semibold px-8 py-3 rounded-full hover:bg-indigo-700 transition duration-300 shadow-lg">
                        Empezar mi Transformación
                    </a>
                    <!-- 
                        Botón principal: fondo azul, texto blanco, borde redondeado, efecto hover y sombra
                    -->

                    <a href="#" 
                       class="text-indigo-600 text-lg font-semibold px-8 py-3 rounded-full border border-indigo-600 hover:bg-indigo-50 transition duration-300">
                        Ver Características
                    </a>
                    <!-- 
                        Botón secundario: fondo transparente, borde azul, hover con fondo azul claro, mismo tamaño y padding
                    -->
                </div>
            </div>

            <!-- Zona destinada a imagen o ilustración -->
            <div class="lg:w-1/2 flex justify-center">
                <!-- lg:w-1/2 → ocupa mitad de ancho en pantallas grandes, flex justify-center → centra horizontalmente -->
                <!-- Imagen ilustrativa opcional -->
            </div>
        </div>
    </main>

    <!-- SECCIÓN INFORMATIVA: “Tu Seguimiento Completo...” -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-6 text-center">
            <!-- text-center → centra todo el contenido dentro de la sección -->

            <h2 class="text-3xl font-bold text-gray-800 mb-10">
                Tu Seguimiento Completo, Dentro y Fuera de la Pista
            </h2>
            <!-- mb-10 → margen inferior grande para separar del grid -->

            <!-- Tarjetas informativas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- grid → grid layout, grid-cols-1 → 1 columna en móviles, md:grid-cols-3 → 3 columnas en pantallas medianas o grandes, gap-8 → espacio entre tarjetas -->

                <!-- TARJETA 1 -->
                <div class="p-6 border rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl text-indigo-500 mb-4">🧠</div>
                    <h3 class="text-xl font-semibold mb-2">Cuerpo y Mente</h3>
                    <p class="text-gray-600">
                        Registra peso, IMC, pasos, calorías y tu estado de ánimo.
                        Un enfoque integral para tu salud.
                    </p>
                </div>

                <!-- TARJETA 2 -->
                <div class="p-6 border rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl text-indigo-500 mb-4">🏸</div>
                    <h3 class="text-xl font-semibold mb-2">Entrenador y Rutinas</h3>
                    <p class="text-gray-600">
                        Rutinas deportivas generadas según tu progreso físico y los objetivos
                        de tu entrenador de pádel.
                    </p>
                </div>

                <!-- TARJETA 3 -->
                <div class="p-6 border rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl text-indigo-500 mb-4">🏆</div>
                    <h3 class="text-xl font-semibold mb-2">Retos Semanales</h3>
                    <p class="text-gray-600">
                        Supera retos y checkpoints para mejorar tu rendimiento deportivo
                        y adherencia a hábitos saludables.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- PIE DE PÁGINA -->
    <footer class="bg-gray-800 text-white mt-12 py-8">
        <!-- bg-gray-800 → fondo oscuro, text-white → texto blanco, mt-12 → margen superior, py-8 → padding vertical -->

        <div class="container mx-auto px-6 text-center text-sm">
            &copy; 2025 FitPadel+. Todos los derechos reservados.
        </div>
        <!-- container → ancho máximo, mx-auto → centrado, text-center → centrado horizontal, text-sm → tamaño de letra pequeño -->
    </footer>

</body>
</html>
