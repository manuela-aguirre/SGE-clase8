<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreCategoryRequest extends FormRequest
{
 // Los permisos se validan en el controlador (middleware de Spatie)
 public function authorize(): bool
 {
 return true;
 }
 public function rules(): array
 {
 return [
 'codigo' => ['nullable', 'string', 'max:20'],
 'nombre' => ['required', 'string', 'max:50'],
 ];
 }
 public function attributes(): array
 {
 return [
 'codigo' => 'código',
 'nombre' => 'nombre',
 ];
 }
}
