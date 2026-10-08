<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreProductRequest extends FormRequest
{
 // Los permisos se validan en el controlador (middleware de Spatie)
 public function authorize(): bool
 {
 return true;
 }
 // Si el checkbox "active" no se marca, el navegador no lo envía: lo dejamos en false
 protected function prepareForValidation(): void
 {
 $this->merge(['active' => $this->boolean('active')]);
 }
 public function rules(): array
 {
 return [
 'name' => ['required', 'string', 'max:150'],
 'description' => ['nullable', 'string'],
 'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
 'stock' => ['required', 'integer', 'min:0'],
 // La categoría debe existir y NO estar en la papelera
 'category_id' => ['required', Rule::exists('categories', 'id')->whereNull('deleted_at')],
 'active' => ['boolean'],
 ];
 }
 public function attributes(): array
 {
 return [
 'name' => 'nombre',
 'description' => 'descripción',
 'price' => 'precio',
 'category_id' => 'categoría',
 ];
 }
}
