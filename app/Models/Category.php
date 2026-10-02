<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
 use SoftDeletes;
 protected $fillable = [
 'name', 'description', 'active'
];
 protected function casts(): array
 {
 return [
 'active' => 'boolean',
 ];
 }
 // Relación: Category tiene muchos Productos
 public function products()
 {
 return $this->hasMany(Product::class);
 }
}
