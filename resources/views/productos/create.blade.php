<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-2xl w-full bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Crear Nuevo Producto</h1>
        <p class="text-gray-500 text-sm mb-8">Ingresa la información para el nuevo registro de inventario.</p>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded">
                <p class="font-bold">Por favor, corrige los siguientes errores:</p>
                <ul class="mt-2 ml-4 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('productos.web.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nombre del Producto</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                       placeholder="Nombre del producto"
                       class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#1a8344] outline-none transition">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
                <textarea name="descripcion" required 
                          class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#1a8344] outline-none transition">{{ old('descripcion') }}</textarea>
            </div>

            <div class="bg-gray-50 p-4 rounded-md border border-dashed border-gray-300">
                <label class="block text-gray-700 font-semibold mb-2">Imagen del Producto</label>
                <input type="file" name="imagen" accept="image/*"
                       class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#1a8344] file:text-white hover:file:bg-[#146b36] cursor-pointer">
                <p class="text-[10px] text-gray-400 mt-2 italic">Formatos permitidos: JPG, PNG, WEBP. Máximo 2MB.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Categoría</label>
                <select name="categoria_id" required 
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#1a8344] outline-none transition">
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" required 
                           class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#1a8344] outline-none transition">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Stock Inicial</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" required 
                           class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#1a8344] outline-none transition">
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('productos.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 flex items-center transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-[#1a8344] text-white px-8 py-2 rounded-md hover:bg-[#146b36] transition font-bold shadow-md">
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>
</body>
</html>