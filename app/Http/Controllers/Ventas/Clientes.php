<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Clientes as ModelsClientes;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Clientes extends Controller
{
    private $usuarioController;
    private $moduloCliente = "admin.ventas.clientes.index";
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function index()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloCliente);
        if(isset($verif['session'])){
            return redirect()->route("home"); 
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $tiposDocumentos = TipoDocumento::where('estado',1)->get();
        return view("intranet.ventas.clientes",compact("modulos","tiposDocumentos"));
    }
    public function listar(Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloCliente);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        $clientes = ModelsClientes::with("tipoDocumento:id,documento")->select("id","nombreCliente","celular","tipoDocumento","nroDocumento","telefono","telefono","correo","direccion","limteCredito","estado");
        return DataTables::of($clientes->get())->toJson();
    }
    public function store(Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloCliente);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        DB::beginTransaction();
        try {
            $datos = $request->all();
            ModelsClientes::create($datos);
            DB::commit();
            return response()->json(['success' => 'cliente agregado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function show(ModelsClientes $cliente)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloCliente);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        return response()->json(['cliente' => $cliente->makeHidden("fechaCreada","fechaActualizada","id")]);
    }
    public function update(ModelsClientes $cliente, Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloCliente);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        DB::beginTransaction();
        try {
            $datos = $request->all();
            $datos['estado'] = $request->has('estado');
            $cliente->update($datos);
            DB::commit();
            return response()->json(['success' => 'cliente actualizado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function destroy(ModelsClientes $cliente)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloCliente);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        DB::beginTransaction();
        try {
            $cliente->delete();
            DB::commit();
            return response()->json(['success' => 'cliente eliminado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
