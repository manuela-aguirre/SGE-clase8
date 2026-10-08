<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            'Distribuidora Andina',
            'Comercial del Valle',
            'Importaciones Pacífico',
            'Suministros Norte',
            'Tecnoparts S.A.S.',
            'Papelería Mayorista',
            'Alimentos del Campo',
            'Químicos y Aseo Ltda.',
            'Ferretería Central',
            'Logística Express',
        ];

        foreach ($proveedores as $i => $nombre) {
            $n = $i + 1;

            Proveedor::create([
                'codigo' => sprintf('PRV-%03d', $n),
                'nombre' => $nombre,
                'nit' => sprintf('900%06d-%d', 100000 + $n * 137, $n % 9 + 1),
                'telefono' => sprintf('300%07d', 1000000 + $n * 7311),
                'email' => 'ventas@'.Str::slug($nombre).'.com',
                'direccion' => 'Calle '.(10 + $n).' # '.(3 + $n).'-'.(10 + $n * 2).', Cartago',
            ]);
        }
    }
}
