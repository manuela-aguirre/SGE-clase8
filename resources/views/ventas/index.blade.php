<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:'Figtree',Arial,sans-serif;font-weight:600;font-size:1.25rem;color:#14532d;">Ventas</h2>
    </x-slot>

    @include('partials.crud-styles')

    <div class="cotec-panel crud-wrap">
        @if (session('status'))
            <div class="status-banner">{{ session('status') }}</div>
        @endif

        <div class="crud-toolbar">
            <form method="GET" action="{{ route('ventas.index') }}" class="crud-search">
                <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por código, cliente o documento...">
            </form>
            <a href="{{ route('ventas.create') }}" class="crud-btn-new">
                <i class="fa-solid fa-plus"></i> Nueva venta
            </a>
        </div>

        @if ($ventas->isEmpty())
            <div class="empty-state">No hay ventas registradas todavía.</div>
        @else
            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Vence</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td style="font-weight:600;color:#0f172a;">{{ $venta->codigo }}</td>
                            <td>{{ $venta->fecha->format('d/m/Y') }}</td>
                            <td>
                                {{ $venta->cliente }}
                                @if ($venta->documento_cliente)
                                    <div style="color:#94a3b8;font-size:0.78rem;">{{ $venta->documento_cliente }}</div>
                                @endif
                            </td>
                            <td>{{ $venta->producto->nombre }}</td>
                            <td>{{ $venta->cantidad }}</td>
                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="crud-badge {{ $venta->estado === 'pagada' ? '' : 'warn' }}">{{ ucfirst($venta->estado) }}</span>
                            </td>
                            <td>{{ $venta->fecha_vencimiento?->format('d/m/Y') ?? '—' }}</td>
                            <td class="crud-actions">
                                @if ($venta->estado === 'pendiente')
                                    <form action="{{ route('ventas.pagar', $venta) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="pay"><i class="fa-solid fa-check"></i> Pagar</button>
                                    </form>
                                @endif
                                <form action="{{ route('ventas.destroy', $venta) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Anular esta venta? El stock se devolverá al inventario.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete"><i class="fa-solid fa-ban"></i> Anular</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:1.25rem;">{{ $ventas->links() }}</div>
        @endif
    </div>
</x-app-layout>
