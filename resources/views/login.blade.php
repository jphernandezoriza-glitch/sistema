<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Practica2</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-2 text-center text-green-700">Bienvenido</h2>
        <p class="text-gray-500 text-sm text-center mb-6">Ingresa tus credenciales institucionales</p>

        {{-- Mostrar errores de validación --}}
        @if ($errors->any())
            <div class="mb-4 p-2 bg-red-100 text-red-600 text-sm rounded">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500" 
                    placeholder="ejemplo@uptex.edu.mx" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                <input type="password" name="password" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500" 
                    placeholder="********" required>
            </div>

            <button type="submit" 
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300 font-semibold">
                Iniciar Sesión
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-gray-400 uppercase tracking-widest">
            UPTEX SOFTWARE DEV
        </p>
    </div>

</body>
</html>