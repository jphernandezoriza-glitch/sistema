<x-mail::message>
# Alerta de Stock Bajo

El siguiente producto ha alcanzado un nivel de inventario crítico en el **Sistema UPTex**.

<x-mail::table>
| Campo      | Valor                           |
| :--------- | :------------------------------ |
| **Producto** | {{ $producto->nombre }}         |
| **Stock** | {{ $producto->stock }} unidades |
| **Precio** | ${{ number_format($producto->precio, 2) }} |
</x-mail::table>

Es necesario revisar el inventario para evitar quedarse sin existencias de este artículo.

<x-mail::button :url="url('/productos')" color="error">
Ver Inventario Completo
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>