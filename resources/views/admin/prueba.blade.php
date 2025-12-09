{{-- 
    @extends: Heredamos la plantilla base de AdminLTE
    ¿Por qué? AdminLTE tiene el layout ya hecho (header, sidebar, footer).
    No repetimos código, solo rellenamos las secciones que necesitamos.
--}}
@extends('adminlte::page')


{{--
    @section 'title': El título que ves en la pestaña del navegador
    ¿Por qué? Así el usuario sabe en qué página está y es bueno para SEO.
--}}
@section('title', 'Página de Prueba - AdminLTE')


{{--
    @section 'content_header': El encabezado de la página (arriba del contenido)
    ¿Por qué? AdminLTE tiene un lugar específico para esto, mantiene todo organizado.
--}}
@section('content_header')
    {{-- El título principal --}}
    <h1 class="d-inline">Página de Prueba AdminLTE</h1>
    
    {{--
        Botón de retorno a dashboard
        - href="{{ route('dashboard') }}: Genera la URL dinámicamente desde las rutas de Laravel
          ¿Por qué? Si cambias la ruta en web.php, este enlace se actualiza solo.
        - class="btn btn-danger": Clases de Bootstrap para botón rojo
          ¿Por qué Bootstrap y no Tailwind? AdminLTE usa Bootstrap, así no hay conflictos.
        - float-right: Empuja el botón a la derecha
        - {{ __('Back to dashboard') }}: Traduce el texto automáticamente según el idioma
          ¿Por qué? Si la app está en inglés o español, se adapta solo.
    --}}
    <a href="{{ route('dashboard') }}" 
        class="btn btn-danger float-right">
        {{ __('Back to dashboard') }}
    </a>
@stop


{{--
    @section 'content': El contenido principal de la página
    ¿Por qué? AdminLTE define diferentes secciones. content_header arriba, content abajo.
--}}
@section('content')
    {{--
        <div class="row">: Fila del sistema de grid de Bootstrap
        ¿Por qué Bootstrap grid? Divide la página en 12 columnas y se adapta a móvil/tablet/escritorio.
    --}}
    <div class="row">
        {{--
            <div class="col-12">: Ocupa las 12 columnas (ancho completo)
            ¿Por qué? Así el contenido usa todo el ancho disponible.
        --}}
        <div class="col-12">
            {{--
                <div class="card">: Una tarjeta Bootstrap (caja con borde y sombra)
                ¿Por qué? Es el componente estándar para agrupar información de forma legible.
            --}}
            <div class="card">
                {{-- card-header: La cabecera de la tarjeta (fondo gris) --}}
                <div class="card-header">
                    <h3 class="card-title">Bienvenido a AdminLTE</h3>
                </div>
                
                {{-- card-body: El cuerpo de la tarjeta (donde va el contenido) --}}
                <div class="card-body">
                    {{--
                        Auth::user(): Obtiene los datos del usuario que está logueado
                        ¿Por qué? Laravel protege esta ruta con middleware,
                        solo usuarios autenticados pueden verla.
                        
                        {{ Auth::user()->name }}: Accede al nombre del usuario
                        Las {{ }} es la sintaxis de Blade para mostrar variables en HTML.
                    --}}
                    <p>Hola <strong>{{ Auth::user()->name }}</strong>, esta es una página de prueba de AdminLTE.</p>
                    <p>Desde aquí puedes acceder a diferentes secciones de la aplicación.</p>
                </div>
            </div>
        </div>
    </div>
@stop
