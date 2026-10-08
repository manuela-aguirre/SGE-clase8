<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'codigo', 'fecha', 'cliente', 'documento_cliente', 'producto_id',
        'cantidad', 'valor_unitario', 'total', 'estado', 'fecha_vencimiento',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'fecha_vencimiento' => 'date',
            'valor_unitario' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    // Relación: Venta pertenece a un Producto
    public function producto()
    {
        return $this->belongsTo(Product::class)->withDefault(['nombre' => 'Sin producto']);
    }

    // Scope: busca por código, cliente o documento
    public function scopeBuscar($query, ?string $texto)
    {
        if (! $texto) {
            return $query;
        }

        return $query->where(function ($q) use ($texto) {
            $q->where('codigo', 'like', "%{$texto}%")
                ->orWhere('cliente', 'like', "%{$texto}%")
                ->orWhere('documento_cliente', 'like', "%{$texto}%");
        });
    }
}
