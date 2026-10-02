<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
 use SoftDeletes;
 protected $fillable = [
 'name', 'description', 'price', 'stock', 'category_id', 'active',
 ];
 protected function casts(): array
 {
 return [
 'price' => 'decimal:2',
 'stock' => 'integer',
 'active' => 'boolean',
 ];
 }
 // Relación: Product pertenece a Category (aunque la categoría esté en la papelera)
 public function category()
 {
 return $this->belongsTo(Category::class)->withTrashed();
 }
}
