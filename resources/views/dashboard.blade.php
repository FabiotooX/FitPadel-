<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">{{ __('Hello') }}, <strong>{{ Auth::user()->name }}</strong></span>

                <!-- Volver a inicio (primero, estilo unificado) -->
                <a href="{{ route('home') }}" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    {{ __('Back to home') }}
                </a>

                <!-- Cerrar sesión (después) -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition duration-300">
                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Hello') }} {{ Auth::user()->name }}!</h3>
                        <p class="text-gray-600">{{ __('Welcome to FitPadel+') }}. {{ __('Here you can manage your profile and access all platform features') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Card: Perfil -->
                        <a href="{{ route('profile.show') }}" class="block p-4 bg-blue-50 border border-blue-200 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <i class="fas fa-user text-blue-600 text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-blue-900">{{ __('My Profile') }}</h4>
                                    <p class="text-sm text-blue-700">{{ __('Edit your information') }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Card: Prueba AdminLTE -->
                        <a href="{{ route('admin.prueba') }}" class="block p-4 bg-green-50 border border-green-200 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <i class="fas fa-flask text-green-600 text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-green-900">{{ __('AdminLTE Test') }}</h4>
                                    <p class="text-sm text-green-700">{{ __('View admin panel') }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Card: Crear Usuarios -->
                        <a href="{{ route('admin.usuarios.crear') }}" class="block p-4 bg-purple-50 border border-purple-200 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <i class="fas fa-user-plus text-purple-600 text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-purple-900">{{ __('Create Users') }}</h4>
                                    <p class="text-sm text-purple-700">{{ __('Manage new users') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                        <p class="text-gray-700"><strong>{{ __('Email Account') }}:</strong> {{ Auth::user()->email }}</p>
                        <p class="text-gray-700"><strong>{{ __('Member since') }}:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
