<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';   // <- agregar

    protected $fillable = [
        'codigo',                       // <- agregar
        'nombre',
    ];

    // Relación: Proveedor tiene muchos Productos
    public function productos()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeBuscar($query, ?string $texto)
    {
        if (! $texto) {
            return $query;
        }

        return $query->where(function ($q) use ($texto) {
            $q->where('nombre', 'like', "%{$texto}%")
                ->orWhere('codigo', 'like', "%{$texto}%");
        });
    }
}