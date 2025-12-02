@extends('adminlte::page')

@section('title', 'Página de Prueba - AdminLTE')

@section('content_header')
    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light me-2">
        <i class="fas fa-chevron-left"></i>
    </a>
    <h1 class="d-inline">Página de Prueba AdminLTE</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bienvenido a AdminLTE</h3>
                </div>
                <div class="card-body">
                    <p>Hola <strong>{{ Auth::user()->name }}</strong>, esta es una página de prueba de AdminLTE.</p>
                    <p>Desde aquí puedes acceder a diferentes secciones de la aplicación.</p>
                    
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">¡Información!</h4>
                        <p>Los estilos de AdminLTE están funcionando correctamente. Esta vista extiende el layout de AdminLTE con menú lateral y navbar superior.</p>
                    </div>

                    <h5>Características de esta página:</h5>
                    <ul>
                        <li>✓ Layout de AdminLTE aplicado</li>
                        <li>✓ Menú lateral funcional</li>
                        <li>✓ Navbar superior con usuario autenticado</li>
                        <li>✓ Acceso solo para usuarios autenticados</li>
                        <li>✓ Componentes Bootstrap 5 disponibles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tarjeta Primaria</h3>
                </div>
                <div class="card-body">
                    Contenido de ejemplo con estilos de AdminLTE
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Tarjeta Éxito</h3>
                </div>
                <div class="card-body">
                    Otro contenido de ejemplo
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Estilos personalizados si los necesitas --}}
@stop

@section('js')
    <script>
        console.log('Página de prueba AdminLTE cargada correctamente');
    </script>
@stop
