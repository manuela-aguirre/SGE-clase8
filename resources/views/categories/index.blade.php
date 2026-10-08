<x-app-layout>
 <x-slot name="header">
 <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
 Categorías {{ $showTrashed ? '(papelera)' : '' }}
 </h2>
 </x-slot>
 <div class="py-6">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    ass="bg-white shadow rounded p-6 space-y-4">
 @if (session('success'))
 <div class="p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
 @endif
 @if (session('error'))
 <div class="p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
 @endif
 <div class="flex flex-wrap gap-4">
 @can('crear-categorias')
 <a href="{{ route('categories.create') }}" class="text-blue-700 underline">+ Nueva categoría</a>
 @endcan
 @can('eliminar-categorias')
 @if ($showTrashed)
 <a href="{{ route('categories.index') }}" class="text-blue-700 underline">Ver categorías</a>
 @else
 <a href="{{ route('categories.index', ['trashed' => 1]) }}" class="text-blue-700 underline">Ver papelera
({{ $trashedCount }})</a>
 @endif
 @endcan
 </div>
 <form method="GET" action="{{ route('categories.index') }}" class="flex flex-wrap gap-2">
 @if ($showTrashed)
 <input type="hidden" name="trashed" value="1">
 @endif
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..." class="bordergray-300 rounded-md">
 <select name="status" class="border-gray-300 rounded-md">
 <option value="">Todos los estados</option>
 <option value="active" @selected(request('status') === 'active')>Activas</option>
 <option value="inactive" @selected(request('status') === 'inactive')>Inactivas</option>
 </select>
 <x-primary-button>Filtrar</x-primary-button>
 </form>
 <table class="min-w-full text-sm">
 <thead>
 <tr class="border-b text-left">
 <th class="p-2">Nombre</th>
 <th class="p-2">Descripción</th>
 <th class="p-2">Productos</th>
 <th class="p-2">Estado</th>
 <th class="p-2">Acciones</th>
 </tr>
 </thead>
 <tbody>
 @forelse ($categories as $category)
 <tr class="border-b">
 <td class="p-2">{{ $category->name }}</td>
 <td class="p-2">{{ $category->description }}</td>
 <td class="p-2">{{ $category->products_count }}</td>
 <td class="p-2">{{ $category->active ? 'Activa' : 'Inactiva' }}</td>
 <td class="p-2 space-x-2">
 @if ($category->trashed())
 <form method="POST" action="{{ route('categories.restore', $category) }}" class="inline">
 @csrf
 @method('PATCH')
 <button type="submit" class="text-green-700 underline">Restaurar</button>
 </form>
 @else
 @can('editar-categorias')
 <a href="{{ route('categories.edit', $category) }}" class="text-blue-700 underline">Editar</a>
 @endcan
 @can('eliminar-categorias')
 <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline"
onsubmit="return confirm('¿Enviar esta categoría a la papelera?')">
 @csrf
 @method('DELETE')
 <button type="submit" class="text-red-700 underline">Eliminar</button>
 </form>
 @endcan
 @endif
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="5" class="p-4 text-center text-gray-500">No hay categorías para mostrar.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 {{ $categories->links() }}
 </div>
 </div>
 </div>
</x-app-layout>