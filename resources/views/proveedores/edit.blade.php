<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:'Figtree',Arial,sans-serif;font-weight:600;font-size:1.25rem;color:#14532d;">Editar Proveedor</h2>
    </x-slot>

    <div class="cotec-panel" style="padding:1.75rem 1.5rem;">
        <form method="POST" action="{{ route('proveedores.update', $proveedor) }}">
            @csrf
            @method('PUT')
            @include('proveedores._form')
        </form>
    </div>
</x-app-layout>
