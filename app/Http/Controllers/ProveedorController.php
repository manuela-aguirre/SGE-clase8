<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    private function rules(?Proveedor $proveedor = null): array
    {
        return [
            'codigo' => ['nullable', 'string', 'max:20', Rule::unique('proveedores', 'codigo')->ignore($proveedor)],
            'nombre' => ['required', 'string', 'max:100'],
            'nit' => ['nullable', 'string', 'max:20'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'direccion' => ['nullable', 'string', 'max:150'],
        ];
    }

    public function index(Request $request)
    {
        $proveedores = Proveedor::withCount('productos')
            ->buscar($request->get('q'))
            ->orderBy('nombre')
            ->paginate(20)
            ->withQueryString();

        return view('proveedores.index', [
            'proveedores' => $proveedores,
            'q' => $request->get('q'),
        ]);
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        Proveedor::create($request->validate($this->rules()));

        return redirect()->route('proveedores.index')->with('status', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', ['proveedor' => $proveedor]);
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $proveedor->update($request->validate($this->rules($proveedor)));

        return redirect()->route('proveedores.index')->with('status', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        // La FK es en cascada: borrar un proveedor borraría sus productos.
        if ($proveedor->productos()->exists()) {
            return redirect()->route('proveedores.index')
                ->with('error', 'No se puede eliminar: el proveedor tiene productos asociados.');
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('status', 'Proveedor eliminado correctamente.');
    }
}
