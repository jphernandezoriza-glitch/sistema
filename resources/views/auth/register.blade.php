<<x-guest-layout>
    <div class="text-center mb-8">
        <img src="{{ asset('img/logo_uptex.png') }}" alt="Logo UPTex" class="w-32 mx-auto mb-4">
        
        <h1 class="text-3xl font-extrabold text-indigo-900">
            Registro <span class="text-indigo-600">UPTex</span>
        </h1>
        <p class="text-sm text-gray-500 italic">Crea tu cuenta institucional</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" class="text-indigo-900 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Institucional')" class="text-indigo-900 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" type="email" name="email" :value="old('email')" placeholder="usuario@alumno.uptex.edu.mx" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" class="text-indigo-900 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-indigo-900 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col space-y-4 mt-6">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-700 hover:bg-indigo-800 transition duration-300 ease-in-out transform hover:-translate-y-1">
                {{ __('Registrar Cuenta') }}
            </x-primary-button>

            <div class="text-center mt-4">
                <a class="underline text-sm text-gray-500 hover:text-indigo-700 transition" href="{{ route('login') }}">
                    {{ __('¿Ya tienes una cuenta? Inicia sesión') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>