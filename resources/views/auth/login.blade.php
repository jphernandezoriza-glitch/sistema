<x-guest-layout>
    <div class="text-center mb-8">
        <img src="{{ asset('img/logo_uptex.png') }}" alt="Logo UPTex" class="w-32 mx-auto mb-4">
        
        <h1 class="text-3xl font-extrabold text-indigo-900">
            Sistema <span class="text-indigo-600">UPTex</span>
        </h1>
        <p class="text-sm text-gray-500 italic">Gestión Universitaria de Productos</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Correo Institucional')" class="text-indigo-900 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                type="email" name="email" :value="old('email')"
                placeholder="usuario@alumno.uptex.edu.mx"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" class="text-indigo-900 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="flex flex-col space-y-4 mt-6">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-700 hover:bg-indigo-800 transition duration-300">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>

            <div class="relative flex items-center py-2">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-xs uppercase">o</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <a href="{{ route('register') }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-white border border-indigo-600 rounded-md font-semibold text-xs text-indigo-600 uppercase tracking-widest shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Crear Cuenta Nueva') }}
            </a>

            <div class="text-center mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-xs text-gray-500 hover:text-indigo-700 transition" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>
        </div>
        </div>
    </form>
</x-guest-layout>