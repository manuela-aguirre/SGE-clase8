<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CompraSeeder extends Seeder
{
    public function run(): void
    {
        $compras = [
            // [días atrás, producto, cantidad, costo unitario, estado]
            [28, 'PRD-0001', 20, 48000, 'recibida'],
            [26, 'PRD-0003', 50, 11000, 'recibida'],
            [21, 'PRD-0009', 5, 150000, 'recibida'],
            [15, 'PRD-0012', 30, 15000, 'recibida'],
            [5, 'PRD-0006', 24, 9500, 'pendiente'],   // stock crítico
            [4, 'PRD-0008', 40, 8200, 'pendiente'],   // stock crítico
            [2, 'PRD-0011', 6, 320000, 'pendiente'],
        ];

        foreach ($compras as [$dias, $codigoProducto, $cantidad, $costo, $estado]) {
            $producto = Product::where('codigo', $codigoProducto)->firstOrFail();
            $fecha = now()->subDays($dias);

            $compra = Compra::create([
                'fecha' => $fecha->toDateString(),
                'proveedor_id' => $producto->proveedor_id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'costo_unitario' => $costo,
                'total' => $cantidad * $costo,
                'estado' => $estado,
                'fecha_recepcion' => $estado === 'recibida' ? $fecha->copy()->addDays(3)->toDateString() : null,
            ]);

            $compra->update(['codigo' => sprintf('COM-%04d', $compra->id)]);
        }
    }
}
