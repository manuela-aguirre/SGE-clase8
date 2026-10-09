<div>
	<x-input-label for="codigo" value="Código (opcional)" />
	<x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo', $category->codigo)" maxlength="20" />
	<x-input-error class="mt-2" :messages="$errors->get('codigo')" />
</div>
<div class="mt-4">
	<x-input-label for="nombre" value="Nombre" />
	<x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $category->nombre)" required maxlength="50" />
	<x-input-error class="mt-2" :messages="$errors->get('nombre')" />
</div>