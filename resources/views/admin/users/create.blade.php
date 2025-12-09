@extends('adminlte::page')

@section('title', __('users.title.create'))

@section('content_header')
    {{-- Botón para volver atrás al listado --}}
    <a href="{{ route('dashboard') }}" 
        class="btn btn-danger float-right">
        {{ __('Back to dashboard') }}
    </a>
    <h1 class="d-inline">{{ __('users.header.create') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('users.form.title') }}</h3>
                </div>

                {{-- 
                    FORMULARIO DE CREACIÓN DE USUARIO
                    
                    action="{{ route('admin.users.store') }}" 
                    - Envía los datos a la ruta 'admin.users.store' (POST /admin/users)
                    - Esto ejecuta el método store() del UserController
                    
                    method="POST"
                    - POST se usa para crear/modificar datos en el servidor
                    - GET se usa solo para obtener datos (nunca para crear)
                    
                    @csrf
                    - Token de seguridad CSRF (Cross-Site Request Forgery)
                    - Laravel lo exige en TODOS los formularios POST, PUT, DELETE
                    - Sin esto, el servidor rechaza el formulario con error 419
                --}}
                <form action="{{ route('admin.users.store') }}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- CAMPO: Nombre --}}
                        <div class="form-group">
                            <label for="name" class="col-form-label">{{ __('users.field.name') }}</label>
                            {{-- 
                                Explicación de atributos:
                                
                                type="text"
                                - Define que es un input de texto normal
                                
                                class="form-control @error('name') is-invalid @enderror"
                                - form-control: estilos de Bootstrap
                                - @error('name') is-invalid: si hay error de validación, añade clase "is-invalid"
                                - is-invalid hace que el campo se vea rojo
                                
                                value="{{ old('name') }}"
                                - Si hay error de validación, mantiene lo que escribió el usuario
                                - old() es una función de Laravel que recupera datos del request anterior
                                - Mejora UX: no tienes que escribir todo de nuevo
                            --}}
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   placeholder="{{ __('users.placeholder.name') }}"
                                   value="{{ old('name') }}"
                                   required>
                            {{-- Mostrar error si existe --}}
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- CAMPO: Email --}}
                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('users.field.email') }}</label>
                            {{-- 
                                type="email"
                                - Valida formato de email a nivel HTML5
                                - Si no es válido, muestra error antes de enviar
                                - Pero la validación REAL ocurre en el servidor (UserController)
                            --}}
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   placeholder="{{ __('users.placeholder.email') }}"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- CAMPO: Contraseña --}}
                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('users.field.password') }}</label>
                            {{-- 
                                type="password"
                                - Oculta los caracteres
                                - Seguridad: si alguien ve la pantalla, no ve la contraseña
                                
                                En el servidor (UserController):
                                - Validamos con Password::class que incluye:
                                  * Mínimo 8 caracteres
                            --}}
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                {{ __('users.password.help') }}
                            </small>
                        </div>

                        {{-- CAMPO: Confirmar Contraseña --}}
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">{{ __('users.field.password_confirmation') }}</label>
                            {{-- 
                                name="password_confirmation"
                                - IMPORTANTE: el nombre debe ser exactamente "password_confirmation"
                                - Laravel busca este campo específicamente
                                - 'confirmed' en la validación verifica que password === password_confirmation
                            --}}
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="{{ __('users.placeholder.password_confirmation') }}"
                                   required>
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="card-footer">
                        {{-- 
                            type="submit"
                            - Al hacer clic, valida el formulario y lo envía a la ruta del action
                            - Laravel valida los datos en el servidor
                            - Si falla validación, retorna el formulario con errores
                            - Si es válido, ejecuta store() y crea el usuario
                        --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('users.button.create') }}
                        </button>
                        {{-- Botón cancelar: vuelve al listado --}}
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> {{ __('users.button.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }
        .card-body {
            padding: 1.5rem;
        }
    </style>
@stop

@section('js')
    <script>
        // Este script se ejecuta cuando la página carga
        console.log('Formulario de creación de usuarios cargado correctamente');
    </script>
@stop
