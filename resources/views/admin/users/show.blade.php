@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light me-2">
        <i class="fas fa-chevron-left"></i>
    </a>
    <h1 class="d-inline">Detalles del usuario</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Nombre:</strong></label>
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>ID:</strong></label>
                                <p>{{ $user->id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Cuenta de correo:</strong></label>
                                <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>Miembro desde:</strong> {{ $user->created_at->format('d/m/Y H:i') }}<br>
                        <strong>Última actualización:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Atrás
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        console.log('Detalles de usuario cargados');
    </script>
@stop
