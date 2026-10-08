@include('partials.crud-styles')

<div class="crud-form">
    <div class="grid-2">
        <div class="field">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" maxlength="20" value="{{ old('codigo', $proveedor->codigo ?? '') }}" placeholder="PRV-011">
            <x-input-error :messages="$errors->get('codigo')" class="mt-1" />
        </div>
        <div class="field">
            <label for="nit">NIT</label>
            <input type="text" id="nit" name="nit" maxlength="20" value="{{ old('nit', $proveedor->nit ?? '') }}">
            <x-input-error :messages="$errors->get('nit')" class="mt-1" />
        </div>
    </div>

    <div class="field">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" maxlength="100" required value="{{ old('nombre', $proveedor->nombre ?? '') }}">
        <x-input-error :messages="$errors->get('nombre')" class="mt-1" />
    </div>

    <div class="grid-2">
        <div class="field">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" maxlength="20" value="{{ old('telefono', $proveedor->telefono ?? '') }}">
            <x-input-error :messages="$errors->get('telefono')" class="mt-1" />
        </div>
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="100" value="{{ old('email', $proveedor->email ?? '') }}">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>
    </div>

    <div class="field">
        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" maxlength="150" value="{{ old('direccion', $proveedor->direccion ?? '') }}">
        <x-input-error :messages="$errors->get('direccion')" class="mt-1" />
    </div>

    <div class="actions">
        <x-primary-button>{{ isset($proveedor) ? 'Actualizar proveedor' : 'Guardar proveedor' }}</x-primary-button>
        <a href="{{ route('proveedores.index') }}" class="btn-cancel">Cancelar</a>
    </div>
</div>
