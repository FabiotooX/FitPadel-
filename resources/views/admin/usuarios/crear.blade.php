@extends('adminlte::page')

@section('title', 'Crear Usuario - FitPadel+')

@section('content_header')
    <h1>Crear Nuevo Usuario</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-10">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Creación de Usuario</h3>
                </div>
                
                <form action="{{ route('admin.usuarios.guardar') }}" method="POST" class="form-horizontal">
                    @csrf
                    
                    <div class="card-body">
                        <!-- Campo: Nombre -->
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre Completo</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   placeholder="Ej: Juan García"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Email -->
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo Electrónico</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Ej: usuario@example.com"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Contraseña -->
                        <div class="form-group">
                            <label for="password" class="col-form-label">Contraseña</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Debe contener al menos 8 caracteres</small>
                        </div>

                        <!-- Campo: Confirmar Contraseña -->
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">Confirmar Contraseña</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Repite tu contraseña"
                                   required>
                        </div>

                        <!-- Campo: Rol (seleccionable) -->
                        <div class="form-group">
                            <label for="role" class="col-form-label">Rol de Usuario</label>
                            <select class="form-control @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role">
                                <option value="">-- Selecciona un rol --</option>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Usuario Regular</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="coach" {{ old('role') === 'coach' ? 'selected' : '' }}>Entrenador</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Estado -->
                        <div class="form-group">
                            <label for="status" class="col-form-label">Estado</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="status" 
                                       name="status"
                                       value="1"
                                       {{ old('status') ? 'checked' : 'checked' }}>
                                <label class="custom-control-label" for="status">
                                    Activo
                                </label>
                            </div>
                        </div>

                        <!-- Mensaje de éxito -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Errores generales -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear Usuario
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
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

        .custom-switch {
            padding-left: 0;
        }

        .custom-control-label {
            margin-top: 0.25rem;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Formulario de creación de usuarios cargado');
    </script>
@stop
