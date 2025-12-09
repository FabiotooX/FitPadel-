@extends('adminlte::page')

@section('title', __('users.index.title'))

@section('content_header')
    {{-- Botón para volver al dashboard --}}
    <a href="{{ route('dashboard') }}" 
        class="btn btn-danger float-right">
        {{ __('Back to dashboard') }}
    </a>
    <h1 class="d-inline">{{ __('users.index.header') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- 
                MENSAJES FLASH (Flash Messages)
                
                session('success') y session('error') son datos temporales que se muestran
                una sola vez después de redirigir. Laravel los elimina después de usarlos.
                
                ¿Cómo se generan?
                En UserController, cuando creamos/editamos/eliminamos:
                return redirect()->route('..')->with('success', 'Mensaje');
                
                ¿Dónde se usan?
                - Crear usuario: "Usuario creado exitosamente."
                - Editar usuario: "Usuario actualizado exitosamente."
                - Eliminar usuario: "Usuario eliminado exitosamente."
            --}}
            
            {{-- Mensaje de éxito (color verde) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    {{-- El usuario puede cerrar el mensaje manualmente --}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Mensaje de error (color rojo) --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de usuarios</h3>
                    <div class="card-tools">
                        {{-- Botón para crear usuario nuevo --}}
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> {{ __('users.index.create') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- 
                        $users->count() > 0 verifica si hay usuarios para mostrar
                    --}}
                    @if ($users->count() > 0)
                        {{-- 
                            TABLA DE USUARIOS
                            
                            Estructura:
                            - thead (encabezado): títulos de columnas
                            - tbody (cuerpo): filas de datos
                            
                            Clases Bootstrap:
                            - table: estilos de tabla
                            - table-bordered: bordes en todas las celdas
                            - table-hover: efecto hover al pasar mouse
                            - table-light: header con fondo gris claro
                        --}}
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('users.table.id') }}</th>
                                                <th>{{ __('users.table.name') }}</th>
                                                <th>{{ __('users.table.email') }}</th>
                                                <th>{{ __('users.table.member_since') }}</th>
                                                <th style="width: 15%">{{ __('users.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- 
                                    @foreach itera sobre cada usuario
                                    $users viene del método index() del UserController
                                    
                                    Ejemplo:
                                    Si index() devuelbe 10 usuarios (paginate(10))
                                    Este bucle se ejecuta 10 veces (una por usuario)
                                --}}
                                @foreach ($users as $user)
                                    <tr>
                                        {{-- Mostrar cada propiedad del usuario --}}
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        {{-- 
                                            created_at es un campo timestamp
                                            ->format('d/m/Y H:i') lo convierte a formato legible
                                            Ejemplo: 09/12/2025 14:30
                                        --}}
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            {{-- BOTÓN VER: Muestra detalles del usuario --}}
                                                          <a href="{{ route('admin.users.show', $user->id) }}" 
                                                              class="btn btn-info btn-xs me-1" 
                                                               title="{{ __('users.action.view') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            {{-- BOTÓN EDITAR: Abre formulario para editar --}}
                                                          <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                              class="btn btn-warning btn-xs me-1" 
                                                               title="{{ __('users.action.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- 
                                                BOTÓN ELIMINAR: Usa formulario DELETE
                                                
                                                ¿Por qué es un formulario, no un enlace?
                                                DELETE debe ser método POST con @method('DELETE')
                                                No podemos usar GET porque podría borrarse por accidente
                                                si alguien escanea enlaces de la página
                                                
                                                @csrf: Token de seguridad (obligatorio en POST/DELETE)
                                                @method('DELETE'): Convierte POST a DELETE
                                                onsubmit="confirm(...)": Pide confirmación al usuario
                                                
                                                Flujo:
                                                1. Usuario hace clic en botón Eliminar
                                                2. JavaScript muestra diálogo de confirmación
                                                3. Si dice "OK", envía formulario POST con @method('DELETE')
                                                4. Laravel entiende que es DELETE y ejecuta destroy()
                                                5. El usuario se elimina de BD
                                            --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('¿Estás seguro? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs" title="{{ __('users.action.delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- 
                            En UserController::index():
                            User::paginate(10) devuelve solo 10 usuarios por página
                            
                            $users->links() genera los botones: Anterior, números, Siguiente
                        --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        {{-- Si no hay usuarios, mostrar mensaje --}}
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('users.empty') }} 
                            <a href="{{ route('admin.users.create') }}" class="alert-link">{{ __('users.empty.create') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        {{-- Estilos personalizados para botones pequeños --}}
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
@stop

@section('js')
    <script>
        // Script que se ejecuta cuando la página carga
        console.log('Página de gestión de usuarios cargada correctamente');
    </script>
@stop
