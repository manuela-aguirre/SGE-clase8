<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:'Figtree',Arial,sans-serif;font-weight:600;font-size:1.25rem;color:#14532d;">Nueva Compra</h2>
    </x-slot>

    @include('partials.crud-styles')

    <div class="cotec-panel" style="padding:1.75rem 1.5rem;">
        <form method="POST" action="{{ route('compras.store') }}">
            @csrf
            <div class="crud-form">
                <div class="field">
                    <label for="producto_id">Producto (ordenados por menor stock)</label>
                    <select id="producto_id" name="producto_id" required>
                        <option value="">Selecciona un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" @selected(old('producto_id', request('producto')) == $producto->id)>
                                {{ $producto->codigo }} · {{ $producto->nombre }} — {{ $producto->proveedor->nombre }}
                                (stock {{ $producto->stock }}{{ $producto->stock <= 2 ? ' · crítico' : '' }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('producto_id')" class="mt-1" />
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" id="cantidad" name="cantidad" min="1" required value="{{ old('cantidad', 1) }}">
                        <x-input-error :messages="$errors->get('cantidad')" class="mt-1" />
                    </div>
                    <div class="field">
                        <label for="costo_unitario">Costo unitario</label>
                        <input type="number" id="costo_unitario" name="costo_unitario" min="0" step="0.01" required value="{{ old('costo_unitario') }}">
                        <x-input-error :messages="$errors->get('costo_unitario')" class="mt-1" />
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required value="{{ old('fecha', now()->format('Y-m-d')) }}">
                        <x-input-error :messages="$errors->get('fecha')" class="mt-1" />
                    </div>
                    <div class="field">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" required>
                            <option value="pendiente" @selected(old('estado', 'pendiente') === 'pendiente')>Pendiente (orden por recibir)</option>
                            <option value="recibida" @selected(old('estado') === 'recibida')>Recibida (suma al stock ahora)</option>
                        </select>
                        <x-input-error :messages="$errors->get('estado')" class="mt-1" />
                    </div>
                </div>

                <p style="color:#64748b;font-size:0.82rem;margin-top:0.25rem;">
                    El proveedor se toma del producto. Una compra pendiente no cambia el inventario hasta que la marques como recibida.
                </p>

                <div class="actions">
                    <x-primary-button>Registrar compra</x-primary-button>
                    <a href="{{ route('compras.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
