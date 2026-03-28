<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen p-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                <h1 class="text-2xl font-bold text-gray-800">Sistema de Inventario</h1>
                
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-md transition duration-300 flex items-center shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                @endauth
            </div>

            @auth
                @php
                    $user = auth()->user();
                    $unreadNotifications = $user?->unreadNotifications ?? collect();
                    $unreadCount = $unreadNotifications->count();
                @endphp

                <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-3 bg-gray-100 flex justify-between items-center border-b border-gray-200">
                        <strong class="text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                            </svg>
                            Panel de Notificaciones
                        </strong>
                        
                        <form action="{{ route('notificaciones.leer') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-blue-600 hover:text-blue-800 relative">
                                Marcar como leídas
                                @if($unreadCount > 0)
                                    <span class="absolute -top-3 -right-4 bg-red-600 text-white text-[10px] px-1.5 py-0.5 rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach($unreadNotifications as $notification)
                            <div class="p-3 hover:bg-white transition-colors">
                                <div class="text-sm text-gray-800">
                                    <span class="text-orange-500">⚠️</span>
                                    {{ $notification->data['mensaje'] ?? 'Stock bajo detectado' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach

                        @if($unreadNotifications->isEmpty())
                            <div class="p-4 text-center text-sm text-gray-500 italic">
                                No hay alertas pendientes.
                            </div>
                        @endif
                    </div>
                </div>
            @endauth

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <form method="GET" action="{{ route('productos.index') }}" class="flex w-full md:w-auto gap-2">
                    <div class="relative flex-grow">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar producto..." 
                               class="w-full md:w-64 pl-4 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#1a8344] focus:border-[#1a8344] outline-none transition">
                    </div>
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md font-semibold transition shadow-sm">
                        Buscar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('productos.index') }}" class="flex items-center text-gray-500 hover:text-red-600 text-sm font-medium px-2">
                            Limpiar
                        </a>
                    @endif
                </form>

                @auth
                    @if(strtolower(auth()->user()->rol) === 'admin')
                        <a href="{{ route('productos.create') }}" class="w-full md:w-auto text-center bg-[#1a8344] hover:bg-[#146b36] text-white px-6 py-2 rounded-md transition duration-300 font-medium shadow-sm">
                            + Nuevo Producto
                        </a>
                    @endif
                @endauth
            </div>

            @auth
                <div class="mb-6 flex flex-wrap gap-3">
                    <a href="{{ route('reportes.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-sm text-sm">PDF</a>
                    <a href="{{ route('reportes.excel') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-sm text-sm">Excel</a>
                    
                    <form action="{{ route('reportes.csv') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm text-sm">
                            Generar CSV (Email)
                        </button>
                    </form>
                </div>
            @endauth

            <div class="mb-8">
                <livewire:buscador-productos />
            </div>

            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-4 font-semibold text-gray-600">Imagen</th>
                            <th class="p-4 font-semibold text-gray-600">Nombre</th>
                            <th class="p-4 font-semibold text-gray-600">Categoría</th>
                            <th class="p-4 font-semibold text-gray-600">Descripción</th>
                            <th class="p-4 font-semibold text-gray-600">Precio</th>
                            <th class="p-4 font-semibold text-gray-600">Stock</th>
                            @auth
                                <th class="p-4 font-semibold text-gray-600 text-right">Acciones</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($productos as $producto)
                        <tr>
                            <td class="p-4">
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-12 h-12 object-cover rounded border border-gray-200">
                                @else
                                    <span class="text-gray-400 text-xs italic">Sin imagen</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-800 font-bold">{{ $producto->nombre }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] uppercase font-bold rounded-md border border-blue-100">
                                    {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500 text-sm">{{ Str::limit($producto->descripcion, 50) }}</td>
                            <td class="p-4 font-bold text-gray-800">${{ number_format($producto->precio, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $producto->stock > 5 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $producto->stock }} unid.
                                </span>
                            </td>
                            @auth
                                <td class="p-4 text-right">
                                    <div class="flex justify-end items-center gap-3">
                                        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-[10px] font-bold py-1 px-2 rounded transition shadow-sm" title="Añadir al carrito">
                                                🛒 AÑADIR
                                            </button>
                                        </form>

                                        @if(strtolower(auth()->user()->rol) === 'admin')
                                            <a href="{{ route('productos.edit', $producto) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs">EDITAR</a>
                                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs">ELIMINAR</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            @endauth
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100" class="p-8 text-center text-gray-500 italic">No hay productos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $productos->appends(['search' => request('search')])->links() }}
            </div>

            <div class="mt-12 border-t pt-8">
                <livewire:formulario-contacto />
            </div>

        </div> 
    </div> 
    @livewireScripts
</body>
</html>