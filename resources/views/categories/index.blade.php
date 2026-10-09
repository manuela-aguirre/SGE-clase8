<x-app-layout>
	<x-slot name="header">
		<h2 style="font-family:'Figtree',Arial,sans-serif;font-weight:600;font-size:1.25rem;color:#14532d;">
			Categorías {{ $showTrashed ? '(papelera)' : '' }}
		</h2>
	</x-slot>

	@include('partials.crud-styles')

	<div class="cotec-panel crud-wrap">
		@if (session('success'))
			<div class="status-banner">{{ session('success') }}</div>
		@endif
		@if (session('error'))
			<div class="status-banner error">{{ session('error') }}</div>
		@endif

		<div class="crud-toolbar">
			<form method="GET" action="{{ route('categories.index') }}" class="crud-search flex flex-wrap items-center gap-2">
				@if ($showTrashed)
					<input type="hidden" name="trashed" value="1">
				@endif
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o código...">
				<x-primary-button>Filtrar</x-primary-button>
			</form>

			<div class="flex flex-wrap items-center gap-3">
				@can('crear-categorias')
					<a href="{{ route('categories.create') }}" class="crud-btn-new">
						<i class="fa-solid fa-plus"></i> Nueva categoría
					</a>
				@endcan
				@can('eliminar-categorias')
					@if ($showTrashed)
						<a href="{{ route('categories.index') }}" class="text-sm font-semibold text-[#14532d] underline">Ver categorías</a>
					@else
						<a href="{{ route('categories.index', ['trashed' => 1]) }}" class="text-sm font-semibold text-[#14532d] underline">
							Papelera ({{ $trashedCount }})
						</a>
					@endif
				@endcan
			</div>
		</div>

		@if ($categories->isEmpty())
			<div class="empty-state">No hay categorías para mostrar.</div>
		@else
			<div class="overflow-x-auto">
				<table class="crud-table">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Productos</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($categories as $category)
							<tr>
								<td>{{ $category->codigo ?? '—' }}</td>
								<td style="font-weight:600;color:#0f172a;">{{ $category->nombre }}</td>
								<td><span class="crud-badge">{{ $category->products_count }}</span></td>
								<td class="crud-actions">
									@if ($category->trashed())
										<form method="POST" action="{{ route('categories.restore', $category) }}" style="display:inline;">
											@csrf
											@method('PATCH')
											<button type="submit" class="pay">Restaurar</button>
										</form>
									@else
										@can('editar-categorias')
											<a class="edit" href="{{ route('categories.edit', $category) }}">
												<i class="fa-solid fa-pen"></i> Editar
											</a>
										@endcan
										@can('eliminar-categorias')
											<form method="POST" action="{{ route('categories.destroy', $category) }}" style="display:inline;" onsubmit="return confirm('¿Enviar esta categoría a la papelera?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="delete">
													<i class="fa-solid fa-trash"></i> Eliminar
												</button>
											</form>
										@endcan
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div style="margin-top:1.25rem;">{{ $categories->links() }}</div>
		@endif
	</div>
</x-app-layout>