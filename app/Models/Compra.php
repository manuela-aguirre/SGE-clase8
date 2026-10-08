<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'codigo', 'fecha', 'proveedor_id', 'producto_id', 'cantidad',
        'costo_unitario', 'total', 'estado', 'fecha_recepcion',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'fecha_recepcion' => 'date',
            'costo_unitario' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    // Relación: Compra pertenece a un Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class)->withDefault(['nombre' => 'Sin proveedor']);
    }

    // Relación: Compra pertenece a un Producto
    public function producto()
    {
        return $this->belongsTo(Product::class)->withDefault(['nombre' => 'Sin producto']);
    }

    // Scope: busca por código, proveedor o producto
    public function scopeBuscar($query, ?string $texto)
    {
        if (! $texto) {
            return $query;
        }

        return $query->where(function ($q) use ($texto) {
            $q->where('codigo', 'like', "%{$texto}%")
                ->orWhereHas('proveedor', fn ($p) => $p->where('nombre', 'like', "%{$texto}%"))
                ->orWhereHas('producto', fn ($p) => $p->where('nombre', 'like', "%{$texto}%"));
        });
    }
}
