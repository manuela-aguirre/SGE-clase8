<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
 public function __invoke(Request $request)
 {
 $user = $request->user();
 // Cada módulo solo se muestra si el usuario tiene el permiso indicado
 $modules = collect([
 [
 'title' => 'Productos',
 'description' => $user->can('crear-productos')
 ? 'Consulta y administra el inventario de productos.'
 : 'Consulta el inventario de productos.',
 'route' => 'products.index',
 'permission' => 'ver-productos',
 ],
 [
 'title' => 'Categorías',
 'description' => $user->can('crear-categorias')
 ? 'Organiza los productos por categoría.'
 : 'Consulta las categorías de productos.',
 'route' => 'categories.index',
 'permission' => 'ver-categorias',
 ],
 ])->filter(fn (array $module) => $user->can($module['permission']))->values();
 $stats = collect();
 if ($user->can('ver-productos')) {
 $stats->push(['label' => 'Productos registrados', 'value' => Product::count()]);
 $stats->push(['label' => 'Stock bajo (≤ 5)', 'value' => Product::where('stock', '<=', 5)->count()]);
 $stats->push(['label' => 'Unidades en inventario', 'value' => Product::sum('stock')]);
 }
 if ($user->can('ver-categorias')) {
 $stats->push(['label' => 'Categorías registradas', 'value' => Category::count()]);
 }
 return view('dashboard', [
 'user' => $user,
 'roles' => $user->getRoleNames(),
 'modules' => $modules,
 'stats' => $stats,
 ]);
 }

 public function usuarios()
 {
 $usuarios = User::query()->latest('created_at')->get();

 return view('usuarios.index', [
 'usuarios' => $usuarios,
 'usuariosVerificados' => $usuarios->whereNotNull('email_verified_at')->count(),
 'totalUsuarios' => $usuarios->count(),
 ]);
 }
}