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

Route::prefix('intranet')->group(function(){
    Route::get('login',[Usuario::class, 'loginView'])->name('viewLogin');
    Route::get('inicio',function(){
        return view('intranet.home');
    })->name('home');
    Route::prefix('productos')->group(function(){
        Route::get('agregar',[MisProductos::class, 'agregarProducto'])->name('addProduct');
        Route::post('agregar',[MisProductos::class, 'nuevoProducto']);
        Route::post('listar',[MisProductos::class, 'obtenerProductos']);

        Route::get('listar',[MisProductos::class,'listaProductos'])->name('listarProductos');
    });
    Route::prefix('usuarios')->group(function(){
        Route::post('accion',[Usuario::class,'getArea']);
        Route::get('/',[Usuario::class,'listarUsuarios'])->name('listarUsuario');
        // Route::get('listar',[Usuario::class,'listarUsuarios'])->name('listarUsuario');
        Route::get('rol',[Rol::class,'viewRol'])->name('usuarioRol');
        Route::get('area', [Area::class, 'viewArea'])->name('usuarioArea');
        Route::post('rol/accion', [Rol::class, 'accionesRoles']);
        Route::post('area/accion', [Area::class, 'accionesArea']);

    });
    Route::prefix('ventas')->group(function(){
        Route::get('agregar',[ventas::class,'viewAgregarVenta'])->name('agregarVentas');
    });
    Route::get("usuario/restaurar",[Usuario::class,'retaurarContra'])->name('restaurarContra');
    Route::post("usuario/restaurar", [Usuario::class, 'retaurarContra']);
    
});

