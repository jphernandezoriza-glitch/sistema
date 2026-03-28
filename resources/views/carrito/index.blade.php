@php
    $total = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen p-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                <h1 class="text-2xl font-bold text-gray-800">Tu Carrito de Compras</h1>
                <a href="{{ route('productos.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a la tienda
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-4 font-semibold text-gray-600">Producto</th>
                            <th class="p-4 font-semibold text-gray-600 text-center">Precio</th>
                            <th class="p-4 font-semibold text-gray-600 text-center">Cantidad</th>
                            <th class="p-4 font-semibold text-gray-600 text-center">Subtotal</th>
                            <th class="p-4 font-semibold text-gray-600 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($carrito as $id => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-800 font-bold">{{ $item['nombre'] }}</td>
                            <td class="p-4 text-center text-gray-600 font-medium">${{ number_format($item['precio'], 2) }}</td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="flex justify-center items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" 
                                           class="w-16 border border-gray-300 rounded-md px-2 py-1 focus:ring-2 focus:ring-blue-500 outline-none text-center">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold py-1.5 px-3 rounded shadow-sm transition">
                                        OK
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-center font-bold text-gray-800">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                            <td class="p-4 text-right">
                                <form method="POST" action="{{ route('carrito.eliminar', $id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wider">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-500 italic">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                El carrito está vacío.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($carrito) > 0)
            <div class="mt-8 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-6 rounded-lg border border-gray-100 shadow-inner">
                <div class="text-2xl text-gray-800">
                    Total a Pagar: <span class="font-extrabold text-[#1a8344]">${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="{{ route('carrito.vaciar') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-md shadow-sm transition">
                        Vaciar Carrito
                    </a>
                    <button class="bg-[#1a8344] hover:bg-[#146b36] text-white font-bold py-2 px-6 rounded-md shadow-sm transition">
                        Pagar Ahora
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>
</body>
</html>