<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categorias';

    protected $fillable = [
        'codigo',                       // <- agregar
        'nombre',
    ];

    // Relación: Categoria tiene muchos Productos
    public function products()
    {
        return $this->hasMany(Product::class, 'categoria_id');
    }
}

