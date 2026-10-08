<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:'Figtree',Arial,sans-serif;font-weight:600;font-size:1.25rem;color:#14532d;">Proveedores</h2>
    </x-slot>

    @include('partials.crud-styles')

    <div class="cotec-panel crud-wrap">
        @if (session('status'))
            <div class="status-banner">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="status-banner error">{{ session('error') }}</div>
        @endif

        <div class="crud-toolbar">
            <form method="GET" action="{{ route('proveedores.index') }}" class="crud-search">
                <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por nombre, código o NIT...">
            </form>
            <a href="{{ route('proveedores.create') }}" class="crud-btn-new">
                <i class="fa-solid fa-plus"></i> Nuevo proveedor
            </a>
        </div>

        @if ($proveedores->isEmpty())
            <div class="empty-state">No hay proveedores registrados todavía.</div>
        @else
            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>NIT</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->codigo ?? '—' }}</td>
                            <td style="font-weight:600;color:#0f172a;">{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->nit ?? '—' }}</td>
                            <td>{{ $proveedor->telefono ?? '—' }}</td>
                            <td>{{ $proveedor->email ?? '—' }}</td>
                            <td><span class="crud-badge">{{ $proveedor->productos_count }}</span></td>
                            <td class="crud-actions">
                                <a class="edit" href="{{ route('proveedores.edit', $proveedor) }}"><i class="fa-solid fa-pen"></i> Editar</a>
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este proveedor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete"><i class="fa-solid fa-trash"></i> Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:1.25rem;">{{ $proveedores->links() }}</div>
        @endif
    </div>
</x-app-layout>
