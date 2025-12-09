@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light me-2">
        <i class="fas fa-chevron-left"></i>
    </a>
    <h1 class="d-inline">Gestionar usuarios</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Mensaje de error -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de usuarios</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Crear usuario
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($users->count() > 0)
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Miembro desde</th>
                                    <th style="width: 15%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-xs me-1" title="Ver">
                                              👁️‍🗨️   
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-xs me-1" title="Editar">
                                                ✏️
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs" title="Eliminar">
                                                    ❌ 
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No se encontraron usuarios.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Gestión de usuarios cargada');
    </script>
@stop
