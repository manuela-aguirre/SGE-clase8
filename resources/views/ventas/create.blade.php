<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:'Figtree',Arial,sans-serif;font-weight:600;font-size:1.25rem;color:#14532d;">Nueva Venta</h2>
    </x-slot>

    @include('partials.crud-styles')

    <div class="cotec-panel" style="padding:1.75rem 1.5rem;">
        <form method="POST" action="{{ route('ventas.store') }}">
            @csrf
            <div class="crud-form">
                <div class="grid-2">
                    <div class="field">
                        <label for="cliente">Cliente</label>
                        <input type="text" id="cliente" name="cliente" maxlength="120" required value="{{ old('cliente') }}">
                        <x-input-error :messages="$errors->get('cliente')" class="mt-1" />
                    </div>
                    <div class="field">
                        <label for="documento_cliente">Documento / NIT</label>
                        <input type="text" id="documento_cliente" name="documento_cliente" maxlength="30" value="{{ old('documento_cliente') }}">
                        <x-input-error :messages="$errors->get('documento_cliente')" class="mt-1" />
                    </div>
                </div>

                <div class="field">
                    <label for="producto_id">Producto</label>
                    <select id="producto_id" name="producto_id" required>
                        <option value="">Selecciona un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" @selected(old('producto_id') == $producto->id)>
                                {{ $producto->codigo }} · {{ $producto->nombre }} (stock {{ $producto->stock }})
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
                        <label for="valor_unitario">Valor unitario</label>
                        <input type="number" id="valor_unitario" name="valor_unitario" min="0" step="0.01" required value="{{ old('valor_unitario') }}">
                        <x-input-error :messages="$errors->get('valor_unitario')" class="mt-1" />
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required value="{{ old('fecha', now()->format('Y-m-d')) }}">
                        <x-input-error :messages="$errors->get('fecha')" class="mt-1" />
                    </div>
                    <div class="field">
                        <label for="fecha_vencimiento">Fecha de vencimiento (opcional)</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}">
                        <x-input-error :messages="$errors->get('fecha_vencimiento')" class="mt-1" />
                    </div>
                </div>

                <div class="field">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>
                        <option value="pendiente" @selected(old('estado', 'pendiente') === 'pendiente')>Pendiente de pago</option>
                        <option value="pagada" @selected(old('estado') === 'pagada')>Pagada</option>
                    </select>
                    <x-input-error :messages="$errors->get('estado')" class="mt-1" />
                </div>

                <div class="actions">
                    <x-primary-button>Registrar venta</x-primary-button>
                    <a href="{{ route('ventas.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
