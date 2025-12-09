@extends('adminlte::page')

@section('title', __('users.title.edit'))

@section('content_header')
    <a href="{{ route('dashboard') }}" 
        class="btn btn-danger float-right">
        {{ __('Back to dashboard') }}
    </a>
    <h1 class="d-inline">{{ __('users.header.edit') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">{{ __('users.form.title') }}</h3>
                </div>

                {{-- 
                    FORMULARIO DE EDICIÓN
                    
                    action="{{ route('admin.users.update', $user->id) }}"
                    - Envía a la ruta 'admin.users.update' con el ID del usuario
                    - URL será: PUT /admin/users/5 (si el usuario tiene id=5)
                    - Ejecuta el método update() del UserController
                    
                    @method('PUT')
                    - HTTP usa PUT para actualizar recursos existentes
                    - Pero HTML solo permite GET y POST
                    - @method('PUT') es un truco: envía POST pero Laravel lo entiende como PUT
                    - Sin esto, el servidor rechazaría la solicitud
                --}}
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        {{-- CAMPO: Nombre --}}
                        <div class="form-group">
                            <label for="name" class="col-form-label">{{ __('users.field.name') }}</label>
                            {{-- 
                                value="{{ old('name', $user->name) }}"
                                
                                Explicación:
                                - old('name') intenta recuperar el valor del request anterior
                                - Si hay error de validación, mostraría el valor que escribiste
                                - Si no hay error, mostraría false
                                
                                Flujo:
                                1. Abres la página: mostraría $user->name (ej: "Juan")
                                2. Editas a "Carlos" pero hay error: mostraría "Carlos"
                                3. Corrige y envía: mostraría "Carlos" (nuevo valor)
                                
                                Resultado: el usuario ve lo que escribió, no el antiguo
                            --}}
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   placeholder="{{ __('users.placeholder.name') }}"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- CAMPO: Email --}}
                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('users.field.email') }}</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   placeholder="{{ __('users.placeholder.email') }}"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- 
                            CAMPO: Contraseña
                            
                            Diferencia con create():
                            - En create(): password es REQUIRED (obligatoria)
                            - En edit(): password es NULLABLE (opcional)
                            
                            ¿Por qué?
                            - Muchas veces editas solo el nombre, no quieres cambiar la contraseña
                            - Si fuera obligatoria, tendrías que escribir contraseña cada vez
                            
                            En UserController::update():
                            if ($request->filled('password')) {
                                // Solo cifra si hay valor nuevo
                                $validated['password'] = Hash::make(...);
                            } else {
                                // Si está vacía, no modifica la contraseña
                                unset($validated['password']);
                            }
                        --}}
                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('users.password.optional') }}</label>
                            {{-- 
                                placeholder="Déjalo vacío para mantener la contraseña actual"
                                - Le dice al usuario qué hacer si no quiere cambiar contraseña
                                - Mejora UX: evita confusión
                            --}}
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="{{ __('users.password.optional.help') }}">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                {{ __('users.password.optional.help') }}
                            </small>
                        </div>

                        {{-- CAMPO: Confirmar Contraseña --}}
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">Confirmar contraseña</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Repetir contraseña">
                        </div>

                        {{-- 
                            INFORMACIÓN ADICIONAL DEL USUARIO
                            
                            Muestra datos útiles que no se pueden editar:
                            - Email: para confirmar que es el usuario correcto
                        --}}
                        <div class="alert alert-info mt-3">
                            <strong>{{ __('users.info.email') }}</strong> {{ $user->email }}<br>
                            {{-- 
                                created_at: timestamp de cuándo se creó el usuario
                                Ejemplo: 2025-12-09 14:30:00 → formatear a 09/12/2025 14:30
                            --}}
                            <strong>{{ __('users.info.member_since') }}</strong> {{ $user->created_at->format('d/m/Y H:i') }}<br>
                            {{-- 
                                updated_at: timestamp de la última actualización
                                Se actualiza automáticamente en Laravel cuando haces update()
                            --}}
                            <strong>{{ __('users.info.last_updated') }}</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="card-footer">
                        {{-- type="submit" envía el formulario con método PUT y ejecuta update() --}}
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> {{ __('users.button.update') }}
                        </button>
                        {{-- Volver al listado sin guardar cambios --}}
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
        // Script cuando la página carga
        console.log('Formulario de edición de usuarios cargado correctamente');
    </script>
@stop
