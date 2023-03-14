<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Perecedero as ModelsPerecedero;
use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Yajra\DataTables\Facades\DataTables;

class Perecedero extends Controller
{
    private $moduloPerecedero = "admin.perecedero.index";
    private $usuarioController;
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function index()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloPerecedero);
        if(isset($verif['session'])){
            return redirect()->route("home"); 
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $productos = Productos::where("estado",1)->get();
        return view("intranet.productos.perecederos",compact("modulos","productos"));

    }
    public function listar(Request $request)
    {
        if(!$request->ajax()){
            return response()->json($this->usuarioController->errorPeticion);
        }
        $accessModulo = $this->usuarioController->validarXmlHttpRequest($this->moduloPerecedero);
        if(isset($accessModulo['session'])){
            return response()->json($accessModulo);
        }
        $perecederos = ModelsPerecedero::with(["productos" => function($producto){
            $producto->select("id","codigoBarra","categoriaFk","marcaFk","nombreProducto","presentacionFk")->with("marca:id,nombreMarca","categoria:id,nombreCategoria","presentacion:id,siglas");
        }])->get()->makeHidden(["fechaCreada","fechaActualizada","productoFk"]);

        return DataTables::of($perecederos)->toJson();
    }
    public function store(Request $request)
    {
        if(!$request->ajax()){
            return response()->json($this->usuarioController->errorPeticion);
        }
        $accessModulo = $this->usuarioController->validarXmlHttpRequest($this->moduloPerecedero);
        if(isset($accessModulo['session'])){
            return response()->json($accessModulo);
        }
        $datos = $request->only("productoFk","cantidad","vencimiento");
        $datos['estado'] = 1;
        $cantidadMaxima = Productos::cantidadMaximaPerecedero($request->productoFk,$request->cantidad);
        if(isset($cantidadMaxima['error'])){
            return response()->json($cantidadMaxima);
        }
        ModelsPerecedero::create($datos);
        return response()->json(['success' => 'perecedero agregado correctamente']);
    }
    public function show(ModelsPerecedero $perecedero, Request $request)
    {
        if(!$request->ajax()){
            return response()->json($this->usuarioController->errorPeticion);
        }
        $accessModulo = $this->usuarioController->validarXmlHttpRequest($this->moduloPerecedero);
        if(isset($accessModulo['session'])){
            return response()->json($accessModulo);
        }
        $perecedero = $perecedero->makeHidden("fechaCreada","fechaActualizada")->toArray();
        return response()->json(["perecedero" => $perecedero]);
    }
    public function update(ModelsPerecedero $perecedero, Request $request)
    {
        if(!$request->ajax()){
            return response()->json($this->usuarioController->errorPeticion);
        }
        $accessModulo = $this->usuarioController->validarXmlHttpRequest($this->moduloPerecedero);
        if(isset($accessModulo['session'])){
            return response()->json($accessModulo);
        }
        $datos = $request->only("cantidad","vencimiento");
        $datos['estado'] = !$request->has("estado") ? 0 : 1;
        $cantidadMaxima = Productos::cantidadMaximaPerecedero($perecedero->productoFk,$request->cantidad,$perecedero->id);
        if(isset($cantidadMaxima['error'])){
            return response()->json($cantidadMaxima);
        }
        $perecedero->update($datos);
        return response()->json(['success' => 'perecedero modificado correctamente']);
    }
    
    public function destroy(ModelsPerecedero $perecedero, Request $request)
    {
        if(!$request->ajax()){
            return response()->json($this->usuarioController->errorPeticion);
        }
        $accessModulo = $this->usuarioController->validarXmlHttpRequest($this->moduloPerecedero);
        if(isset($accessModulo['session'])){
            return response()->json($accessModulo);
        }
        // if($marca->productos()->count() > 0){
        //     return ["alerta" => "Debes eliminar primero los productos relacionados a esta marca"];
        // }
        $perecedero->delete();
        return response()->json(['success' => 'marca eliminada correctamente']);
    }
}
