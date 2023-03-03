<?php

use App\Http\Controllers\Producto\Categoria;
use App\Http\Controllers\Producto\Marca;
use App\Http\Controllers\Producto\MisProductos;
use App\Http\Controllers\Producto\Presentacion;
use App\Http\Controllers\Usuario;
use App\Http\Controllers\Usuario\Area;
use App\Http\Controllers\Usuario\Rol;
use App\Http\Controllers\ventas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
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
        Route::prefix('marca')->group(function () {
            Route::get('/', [Marca::class, 'index'])->name('admin.marca.index');
            Route::post('listar', [Marca::class, 'listar']);
            Route::get('listar/{marca}', [Marca::class, 'show']);
            Route::post('crear', [Marca::class, 'store']);
            Route::post('editar/{marca}', [Marca::class, 'update']);
            Route::delete('eliminar/{marca}', [Marca::class, 'destroy']);
        });
        Route::prefix('categoria')->group(function () {
            Route::get('/', [Categoria::class, 'index'])->name('admin.categoria.index');
            Route::post('listar', [Categoria::class, 'listar']);
            Route::get('listar/{categoria}', [Categoria::class, 'show']);
            Route::post('crear', [Categoria::class, 'store']);
            Route::post('editar/{categoria}', [Categoria::class, 'update']);
            Route::delete('eliminar/{categoria}', [Categoria::class, 'destroy']);
        });
        Route::prefix('presentacion')->group(function () {
            Route::get('/', [Presentacion::class, 'index'])->name('admin.presentacion.index');
            Route::post('listar', [Presentacion::class, 'listar']);
            Route::get('listar/{presentacion}', [Presentacion::class, 'show']);
            Route::post('crear', [Presentacion::class, 'store']);
            Route::post('editar/{presentacion}', [Presentacion::class, 'update']);
            Route::delete('eliminar/{presentacion}', [Presentacion::class, 'destroy']);
        });
        Route::prefix('producto')->group(function () {
            Route::get('/', [MisProductos::class, 'index'])->name('admin.producto.index');
            Route::post('listar', [MisProductos::class, 'listar']);
            Route::get('listar/{producto}', [MisProductos::class, 'show']);
            Route::post('crear', [MisProductos::class, 'store']);
            Route::post('editar/{producto}', [MisProductos::class, 'update']);
            Route::delete('eliminar/{producto}', [MisProductos::class, 'destroy']);
        });
       
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
    Route::get('storage/{filename}', function ($filename){
        $path = storage_path('app/productos/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    })->name("urlImagen"); 
});
Route::middleware(['guest'])->prefix('intranet')->group(function () {
    Route::get('login', [Usuario::class, 'loginView'])->name('login');
    Route::get("usuario/restaurar", [Usuario::class, 'retaurarContra'])->name('restaurarContra');
    Route::post("usuario/autenticacion", [Usuario::class, 'autenticacion']);
    Route::post("usuario/restaurar", [Usuario::class, 'restaurarContrasena']);
});


