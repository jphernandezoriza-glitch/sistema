<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - {{ $producto->nombre }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen p-8">

    <div class="max-w-6xl mx-auto">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
            
            <div class="mb-8 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">Editar Producto</h1>
                <p class="text-gray-500 text-sm">
                    Actualizando la información de:
                    <span class="font-semibold text-[#1a8344]">{{ $producto->nombre }}</span>
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold mb-1">Por favor, corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('productos.web.update', $producto->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Producto</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                        placeholder="Nombre del producto"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#1a8344] focus:border-[#1a8344] outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#1a8344] focus:border-[#1a8344] outline-none transition">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="bg-gray-50 p-4 rounded-md border border-dashed border-gray-300">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Imagen del Producto</label>
                    
                    @if($producto->imagen)
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 mb-1">Imagen actual:</p>
                            <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                 alt="{{ $producto->nombre }}" 
                                 class="w-32 h-32 object-cover rounded-lg border shadow-sm">
                        </div>
                    @endif

                    <input type="file" name="imagen" accept="image/*"
                        class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#1a8344] file:text-white hover:file:bg-[#146b36] cursor-pointer">
                    <p class="text-[10px] text-gray-400 mt-2 italic">Formatos permitidos: JPG, PNG, WEBP. Máx 2MB. Deja vacío para mantener la actual.</p>
                </div>

                <div class="mb-4">
                    <label for="categoria_id" class="block text-sm font-semibold text-gray-700 mb-1">Categoría</label>
                    <select name="categoria_id" id="categoria_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1a8344] transition">
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ (old('categoria_id', $producto->categoria_id) == $categoria->id) ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Precio ($)</label>
                        <input type="number" name="precio" step="0.01" value="{{ old('precio', $producto->precio) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#1a8344] focus:border-[#1a8344] outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Stock Actual</label>
                        <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#1a8344] focus:border-[#1a8344] outline-none transition">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <a href="{{ route('productos.index') }}"
                       class="text-gray-600 hover:text-gray-800 font-medium transition">
                         Cancelar
                    </a>
                    <button type="submit"
                        class="bg-[#1a8344] hover:bg-[#146b36] text-white px-8 py-2 rounded-md font-bold transition duration-300 shadow-md">
                        Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>