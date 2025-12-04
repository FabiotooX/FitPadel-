@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light me-2">
        <i class="fas fa-chevron-left"></i>
    </a>
    <h1 class="d-inline">Editar usuario</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Información del usuario</h3>
                </div>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- Campo Nombre -->
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre *</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   placeholder="Nombre completo"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo Email -->
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo *</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   placeholder="Dirección de correo"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo Contraseña (opcional para edición) -->
                        <div class="form-group">
                            <label for="password" class="col-form-label">Contraseña</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Déjalo vacío para mantener la contraseña actual">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Déjalo vacío para mantener la contraseña actual. Si cambia, debe tener al menos 8 caracteres</small>
                        </div>

                        <!-- Campo Confirmar Contraseña -->
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">Confirmar contraseña</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Repetir contraseña">
                        </div>

                        <!-- Información adicional -->
                        <div class="alert alert-info mt-3">
                            <strong>Cuenta de correo:</strong> {{ $user->email }}<br>
                            <strong>Miembro desde:</strong> {{ $user->created_at->format('d/m/Y H:i') }}<br>
                            <strong>Última actualización:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Actualizar usuario
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
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
        console.log('Formulario de edición de usuarios cargado');
    </script>
@stop
