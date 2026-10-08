<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Venta;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        $productos = Product::pluck('id', 'codigo');

        $ventas = [
            // [días atrás, cliente, documento, producto, cantidad, valor unitario, estado, plazo en días]
            [30, 'María López', '1020304050', 'PRD-0001', 2, 65000, 'pagada', null],
            [25, 'Carlos Pérez', '1098765432', 'PRD-0003', 10, 14000, 'pagada', null],
            [20, 'Ana Torres', '1011223344', 'PRD-0009', 1, 189000, 'pendiente', 15],
            [14, 'Luis Gómez', '1055667788', 'PRD-0004', 20, 6500, 'pagada', null],
            [10, 'Sofía Ramírez', '1033445566', 'PRD-0012', 3, 22000, 'pendiente', 30],
            [7, 'Comercial Los Andes S.A.S.', '900123456-1', 'PRD-0005', 6, 18500, 'pendiente', 5],
            [3, 'Ana Torres', '1011223344', 'PRD-0013', 2, 48000, 'pagada', null],
            [1, 'Carlos Pérez', '1098765432', 'PRD-0010', 4, 35000, 'pendiente', 30],
        ];

        foreach ($ventas as [$dias, $cliente, $documento, $codigoProducto, $cantidad, $valor, $estado, $plazo]) {
            $fecha = now()->subDays($dias);

            $venta = Venta::create([
                'fecha' => $fecha->toDateString(),
                'cliente' => $cliente,
                'documento_cliente' => $documento,
                'producto_id' => $productos[$codigoProducto],
                'cantidad' => $cantidad,
                'valor_unitario' => $valor,
                'total' => $cantidad * $valor,
                'estado' => $estado,
                'fecha_vencimiento' => $plazo ? $fecha->copy()->addDays($plazo)->toDateString() : null,
            ]);

            $venta->update(['codigo' => sprintf('VEN-%04d', $venta->id)]);
        }
    }
}
