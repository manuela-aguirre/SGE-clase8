<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Listado de productos (con() evita el problema N+1 al cargar
     * la proveedor y el categoría de cada producto en una sola consulta extra).
     */
    public function index(Request $request)
    {
        $productos = Producto::with(['proveedor', 'categoria'])
            ->buscar($request->get('q'))
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('products.index', [
            'productos' => $productos,
            'q' => $request->get('q'),
        ]);
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        return view('products.create', [
            'proveedores' => Proveedor::orderBy('nombre')->get(),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    /**
     * Guarda un producto nuevo (con validación básica).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'imagen_url' => ['nullable', 'url', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'codigo' => ['nullable', 'string', 'max:20'],
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ]);

        Producto::create($validated);

        return redirect()
            ->route('products.index')
            ->with('status', 'Producto creado correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Producto $producto)
    {
        return view('products.edit', [
            'producto' => $producto,
            'proveedores' => Proveedor::orderBy('nombre')->get(),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    /**
     * Actualiza un producto existente.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'imagen_url' => ['nullable', 'url', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'codigo' => ['nullable', 'string', 'max:20'],
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ]);

        $producto->update($validated);

        return redirect()
            ->route('products.index')
            ->with('status', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'Producto eliminado correctamente.');
    }
}
