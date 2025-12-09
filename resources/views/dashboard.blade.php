<x-app-layout>
    {{-- 
        x-slot name="header": Definimos la cabecera de la página.
        Por qué: Permite personalizar la cabecera en cada página usando un layout común.
    --}}
    <x-slot name="header">
        {{-- Contenedor flexible para alinear elementos a izquierda y derecha --}}
        <div class="flex justify-between items-center">
            {{-- Título principal de la página --}}
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            {{-- Contenedor de elementos a la derecha (saludo y botón) --}}
                <div class="flex items-center space-x-4">
                {{-- Muestra el nombre del usuario autenticado --}}
                <span class="text-sm text-gray-600">
                    {{ __('Hello') }}, <strong>{{ Auth::user()->name }}</strong>
                </span>

                {{-- Botón para volver a la página principal --}}
                <a href="{{ route('home') }}" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    {{ __('Back to home') }}
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Contenido principal de la página --}}
    <div class="py-12">
        {{-- Contenedor central con ancho máximo y padding --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Caja con fondo blanco, sombra y bordes redondeados --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- Mensaje de bienvenida y descripción --}}
                    <div class="mb-6">
                        {{-- Saludo al usuario --}}
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ __('Hello') }} {{ Auth::user()->name }}!
                        </h3>
                        {{-- Texto descriptivo --}}
                        <p class="text-gray-600">
                            {{ __('Welcome to FitPadel+. Here you can manage your profile and access all platform features') }}
                        </p>
                    </div>

                    {{-- Grid de tarjetas de acción --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Tarjeta: Perfil --}}
                        <a href="{{ route('profile.show') }}" class="block p-4 bg-blue-50 border border-blue-200 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <i class="fas fa-user text-blue-600 text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-blue-900">{{ __('My Profile') }}</h4>
                                    <p class="text-sm text-blue-700">{{ __('Edit your information') }}</p>
                                </div>
                            </div>
                        </a>

                        {{-- Tarjeta: Prueba AdminLTE --}}
                        <a href="{{ route('admin.prueba') }}" class="block p-4 bg-green-50 border border-green-200 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <i class="fas fa-flask text-green-600 text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-green-900">{{ __('AdminLTE Test') }}</h4>
                                    <p class="text-sm text-green-700">{{ __('View admin panel') }}</p>
                                </div>
                            </div>
                        </a>

                        {{-- Tarjeta: Crear Usuarios --}}
                        <a href="{{ route('admin.users.create') }}" class="block p-4 bg-purple-50 border border-purple-200 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <i class="fas fa-user-plus text-purple-600 text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-purple-900">{{ __('Create Users') }}</h4>
                                    <p class="text-sm text-purple-700">{{ __('Manage new users') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    {{-- Información adicional del usuario --}}
                    <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                        {{-- Email del usuario --}}
                        <p class="text-gray-700">
                            <strong>{{ __('Email account: ') }}</strong> {{ Auth::user()->email }}
                        </p>
                        {{-- Fecha de alta del usuario --}}
                        <p class="text-gray-700">
                            <strong>{{ __('Member since: ') }}</strong> {{ Auth::user()->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>