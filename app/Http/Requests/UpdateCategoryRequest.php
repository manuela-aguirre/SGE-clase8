<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// Usa las mismas reglas que StoreCategoryRequest
class UpdateCategoryRequest extends StoreCategoryRequest
{
 // Los permisos se validan en el controlador (middleware de Spatie)
 public function authorize(): bool
 {
 return true;
 }
 protected function prepareForValidation(): void
 {
 $this->merge(['active' => $this->boolean('active')]);
 }
 public function rules(): array
 {
 return [
 'name' => [
 'required', 'string', 'max:100',
 // Nombre único entre las categorías que no están en la papelera
 Rule::unique('categories', 'name')->withoutTrashed()->ignore($this->route('category')),
 ],
 'description' => ['nullable', 'string'],
 'active' => ['boolean'],
 ];
 }
 public function attributes(): array
 {
 return [
 'name' => 'nombre',
 'description' => 'descripción',
 ];
 }
}