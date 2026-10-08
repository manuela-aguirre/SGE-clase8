<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Tecnología',
            'Papelería',
            'Aseo',
            'Alimentos',
            'Ferretería',
            'Hogar',
            'Oficina',
            'Electrónica',
            'Herramientas',
            'Accesorios',
        ];

        foreach ($categorias as $i => $nombre) {
            Category::create([
                'codigo' => sprintf('CAT-%02d', $i + 1),
                'nombre' => $nombre,
            ]);
        }
    }
}