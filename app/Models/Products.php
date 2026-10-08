<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'descripcion', 'imagen_url', 'stock', 'codigo', 'proveedor_id', 'categoria_id',
    ];

    // Relación: Producto pertenece a una Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class)->withDefault([
            'nombre' => 'Sin proveedor',
        ]);
    }

    // Relación: Producto pertenece a un Categoría
    public function category()
    {
        $relacion = $this->belongsTo(Categoria::class)->withDefault([
            'nombre' => 'Sin categoría',
        ]);

        $relacion->withTrashed();

        return $relacion;
    }

    /**
     * Scope reutilizable: filtra productos por texto (título o Código).
     * Uso: Producto::buscar($texto)->get();
     */
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

    /**
     * Scope reutilizable: solo productos con stock disponible.
     * Uso: Producto::conStock()->get();
     */
    public function scopeConStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
