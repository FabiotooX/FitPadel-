@extends('adminlte::page')

@section('title', __('users.show.title'))

@section('content_header')
    {{-- Botón para volver al listado --}}
    <a href="{{ route('dashboard') }}" 
        class="btn btn-danger float-right">
        {{ __('Back to dashboard') }}
    </a>
    <h1 class="d-inline">{{ __('users.show.header') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    {{-- Mostrar nombre del usuario en el título --}}
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>

                <div class="card-body">
                    {{-- 
                        INFORMACIÓN DEL USUARIO
                        
                        Este es el método show() del UserController.
                        Solo muestra información, no es editable.
                        
                        Ver detalles de un usuario sin modificar
                        Saber email, fecha de registro, etc.
                        Revisar información antes de eliminar
                    --}}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>{{ __('users.show.name') }}</strong></label>
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>{{ __('users.show.id') }}</strong></label>
                                {{-- 
                                    El ID es importante para identificar únicamente al usuario
                                    No se puede cambiar, es la clave primaria en la BD
                                --}}
                                <p>
                                    <code>{{ $user->id }}</code>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>{{ __('users.show.email') }}</strong></label>
                                {{-- 
                                    href="mailto:{{ $user->email }}"
                                    - Hace que el email sea un enlace clickeable
                                    - Al hacer clic, abre el cliente de correo por defecto
                                --}}
                                <p>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                        {{ $user->email }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- 
                        Estos campos se generan automáticamente en Laravel:
                        - created_at: se genera cuando se ejecuta User::create()
                        - updated_at: se genera al crear y se actualiza con User::update()
                    --}}
                        <div class="alert alert-info">
                        <i class="fas fa-clock me-2"></i>
                        <strong>{{ __('users.info.member_since') }}</strong> {{ $user->created_at->format('d/m/Y \a \l\a\s H:i') }}<br>
                        <strong>{{ __('users.info.last_updated') }}</strong> {{ $user->updated_at->format('d/m/Y \a \l\a\s H:i') }}
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="card-footer">
                    {{-- Botón para editar el usuario --}}
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> {{ __('users.action.edit') }}
                    </a>
                    {{-- Volver al listado sin guardar cambios --}}
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> {{ __('users.show.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Script cuando la página carga
        console.log('Página de detalles de usuario cargada correctamente');
    </script>
@stop
