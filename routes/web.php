<?php

use App\Http\Controllers\Producto\MisProductos;
use App\Http\Controllers\Usuario;
use App\Http\Controllers\Usuario\Area;
use App\Http\Controllers\Usuario\Rol;
use App\Http\Controllers\ventas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->prefix('intranet')->group(function(){
    Route::get('inicio', [Usuario::class, 'index'])->name('home');
    Route::prefix('almacen')->group(function () {
        Route::get('marca', [Usuario::class, 'cambioRol'])->name('admin.marca.index');
        Route::get('categoria', [Usuario::class, 'listarUsuarios'])->name('admin.categoria.index');
        Route::get('presentacion', [Usuario::class, 'listarUsuarios'])->name('admin.presentacion.index');
        Route::get('producto', [Usuario::class, 'listarUsuarios'])->name('admin.producto.index');
    });
    Route::prefix('ventas')->group(function () {
        Route::get('registrar', [Usuario::class, 'cambioRol'])->name('ventas.registrar.index');
    });
    Route::prefix('usuarios')->group(function(){
        Route::post('accion',[Usuario::class,'getArea']);
        Route::get('cambio/rol/{rol}', [Usuario::class, 'cambioRol'])->name('cambiarRol');
        Route::get('/',[Usuario::class,'listarUsuarios'])->name('admin.usuario.index');
        Route::get('cerrar/sesion', [Usuario::class, 'logoauth'])->name('cerrarSesion');
        Route::get('rol',[Rol::class,'viewRol'])->name('admin.rol.index');
        Route::get('area', [Area::class, 'viewArea'])->name('admin.area.index');
        Route::post('rol/accion', [Rol::class, 'accionesRoles']);
        Route::post('area/accion', [Area::class, 'accionesArea']);

    });
});
Route::middleware(['guest'])->prefix('intranet')->group(function () {
    Route::get('login', [Usuario::class, 'loginView'])->name('login');
    Route::get("usuario/restaurar", [Usuario::class, 'retaurarContra'])->name('restaurarContra');
    Route::post("usuario/autenticacion", [Usuario::class, 'autenticacion']);
    Route::post("usuario/restaurar", [Usuario::class, 'restaurarContrasena']);
});


