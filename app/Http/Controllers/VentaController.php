<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $ventas = Venta::with('producto')
            ->buscar($request->get('q'))
            ->latest('fecha')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('ventas.index', [
            'ventas' => $ventas,
            'q' => $request->get('q'),
        ]);
    }

    public function create()
    {
        return view('ventas.create', [
            'productos' => Product::conStock()->orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha' => ['required', 'date'],
            'cliente' => ['required', 'string', 'max:120'],
            'documento_cliente' => ['nullable', 'string', 'max:30'],
            'producto_id' => ['required', 'exists:productos,id'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'valor_unitario' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', 'in:pendiente,pagada'],
            'fecha_vencimiento' => ['nullable', 'date', 'after_or_equal:fecha'],
        ]);

        DB::transaction(function () use ($data) {
            $producto = Product::lockForUpdate()->findOrFail($data['producto_id']);

            if ($producto->stock < $data['cantidad']) {
                throw ValidationException::withMessages([
                    'cantidad' => "Stock insuficiente: solo hay {$producto->stock} unidades.",
                ]);
            }

            $venta = Venta::create($data + ['total' => $data['cantidad'] * $data['valor_unitario']]);
            $venta->update(['codigo' => sprintf('VEN-%04d', $venta->id)]);
            $producto->decrement('stock', $data['cantidad']);
        });

        return redirect()->route('ventas.index')->with('status', 'Venta registrada correctamente.');
    }

    public function pagar(Venta $venta)
    {
        $venta->update(['estado' => 'pagada']);

        return redirect()->route('ventas.index')
            ->with('status', "Venta {$venta->codigo} marcada como pagada.");
    }

    public function destroy(Venta $venta)
    {
        DB::transaction(function () use ($venta) {
            $venta->producto()->increment('stock', $venta->cantidad);
            $venta->delete();
        });

        return redirect()->route('ventas.index')->with('status', 'Venta anulada y stock devuelto al inventario.');
    }
}
