<x-app-layout>
    <x-slot name="header">
        {{--
            Botón de retorno a dashboard
            - href="{{ route('dashboard') }}: Genera la URL dinámicamente desde las rutas de Laravel
            ¿Por qué? Si cambias la ruta en web.php, este enlace se actualiza solo.
            - class="btn btn-danger": Clases de Bootstrap para botón rojo
            ¿Por qué Bootstrap y no Tailwind? AdminLTE usa Bootstrap, así no hay conflictos.
            - float-right: Empuja el botón a la derecha
            - {{ __('Back to dashboard') }}: Traduce el texto automáticamente según el idioma
            ¿Por qué? Si la app está en inglés o español, se adapta solo.
        --}}
        <a href="{{ route('dashboard') }}" 
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 float-right">
            {{ __('Back to dashboard') }}
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight d-inline">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
