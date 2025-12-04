@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light me-2">
        <i class="fas fa-chevron-left"></i>
    </a>
    <h1 class="d-inline">Crear usuario</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información del usuario</h3>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        <!-- Campo Nombre -->
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre *</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   placeholder="Nombre completo"
                                   value="{{ old('name') }}"
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
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="form-group">
                            <label for="password" class="col-form-label">Contraseña *</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Debe tener al menos 8 caracteres</small>
                        </div>

                        <!-- Campo Confirmar Contraseña -->
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">Confirmar contraseña *</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Repetir contraseña"
                                   required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear usuario
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
        console.log('Formulario de creación de usuarios cargado');
    </script>
@stop
