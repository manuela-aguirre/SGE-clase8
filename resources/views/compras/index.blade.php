<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:'Figtree',Arial,sans-serif;font-weight:600;font-size:1.25rem;color:#14532d;">Compras</h2>
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
            <form method="GET" action="{{ route('compras.index') }}" class="crud-search">
                <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por código, proveedor o producto...">
            </form>
            <a href="{{ route('compras.create') }}" class="crud-btn-new">
                <i class="fa-solid fa-plus"></i> Nueva compra
            </a>
        </div>

        @if ($compras->isEmpty())
            <div class="empty-state">No hay compras registradas todavía.</div>
        @else
            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Costo unit.</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Recepción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr>
                            <td style="font-weight:600;color:#0f172a;">{{ $compra->codigo }}</td>
                            <td>{{ $compra->fecha->format('d/m/Y') }}</td>
                            <td>{{ $compra->proveedor->nombre }}</td>
                            <td>
                                {{ $compra->producto->nombre }}
                                <div style="color:#94a3b8;font-size:0.78rem;">Stock actual: {{ $compra->producto->stock }}</div>
                            </td>
                            <td>{{ $compra->cantidad }}</td>
                            <td>${{ number_format($compra->costo_unitario, 0, ',', '.') }}</td>
                            <td>${{ number_format($compra->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="crud-badge {{ $compra->estado === 'recibida' ? '' : 'warn' }}">{{ ucfirst($compra->estado) }}</span>
                            </td>
                            <td>{{ $compra->fecha_recepcion?->format('d/m/Y') ?? '—' }}</td>
                            <td class="crud-actions">
                                @if ($compra->estado === 'pendiente')
                                    <form action="{{ route('compras.recibir', $compra) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Marcar como recibida? El stock del producto aumentará {{ $compra->cantidad }} unidades.');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="pay"><i class="fa-solid fa-box-open"></i> Recibir</button>
                                    </form>
                                @endif
                                <form action="{{ route('compras.destroy', $compra) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Anular esta compra? Si ya fue recibida, el stock se descontará.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete"><i class="fa-solid fa-ban"></i> Anular</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:1.25rem;">{{ $compras->links() }}</div>
        @endif
    </div>
</x-app-layout>
