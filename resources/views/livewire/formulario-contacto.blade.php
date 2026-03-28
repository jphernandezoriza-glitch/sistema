<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $nombre = '';
    public string $email = '';

    protected $rules = [
        'nombre' => 'required|min:3',
        'email' => 'required|email',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'El nombre debe tener al menos 3 letras.',
        'email.required' => 'El correo es necesario.',
        'email.email' => 'Formato de correo no válido.',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function enviar() {
        $this->validate();
        session()->flash('mensaje', '¡Formulario enviado con éxito!');
        $this->reset(['nombre', 'email']);
    }
}; ?>

<div class="mt-10 p-6 bg-white rounded-lg shadow-md border-t-4 border-blue-500">
    <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Formulario de Contacto</h2>

    @if (session()->has('mensaje'))
        <div class="p-3 mb-4 bg-green-100 text-green-700 rounded-md text-sm font-bold">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="space-y-4">
        <div>
            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nombre Completo</label>
            <input wire:model.blur="nombre" type="text" 
                   class="w-full p-2 border {{ $errors->has('nombre') ? 'border-red-500' : 'border-gray-300' }} rounded outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Escribe tu nombre...">
            @error('nombre') 
                <p class="text-red-500 text-[10px] mt-1 font-bold italic">{{ $message }}</p> 
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Correo Electrónico</label>
            <input wire:model.blur="email" type="text" 
                   class="w-full p-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="ejemplo@uptex.com">
            @error('email') 
                <p class="text-red-500 text-[10px] mt-1 font-bold italic">{{ $message }}</p> 
            @enderror
        </div>

        <button wire:click="enviar" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded transition">
            Enviar Mensaje
        </button>
    </div>
</div>