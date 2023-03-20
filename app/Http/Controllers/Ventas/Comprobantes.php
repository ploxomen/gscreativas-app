<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Comprobantes as ModelsComprobantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Comprobantes extends Controller
{
    private $usuarioController;
    private $moduloComprobantes = "admin.ventas.comprobantes.index";
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function index()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloComprobantes);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();

        return view("intranet.ventas.comprobantes", compact("modulos"));
    }
    public function listar(Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloComprobantes);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $comprobantes = ModelsComprobantes::select("id","comprobante","estado","serie", "inicio", "fin", "disponibles", "utilizados");
        return DataTables::of($comprobantes->get())->toJson();
    }
    public function store(Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloComprobantes);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        DB::beginTransaction();
        try {
            $datos = $request->only("comprobante", "serie", "inicio", "fin", "disponibles", "utilizados");
            ModelsComprobantes::create($datos);
            DB::commit();
            return response()->json(['success' => 'comprobante agregado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function show(ModelsComprobantes $comprobante)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloComprobantes);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        return response()->json(['comprobante' => $comprobante->makeHidden("fechaCreada", "fechaActualizada", "id")]);
    }
    public function update(Modelscomprobantes $comprobante, Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloComprobantes);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        DB::beginTransaction();
        try {
            $datos = $request->only("comprobante", "serie", "inicio", "fin", "disponibles", "utilizados");
            $datos['estado'] = $request->has('estado');
            $comprobante->update($datos);
            DB::commit();
            return response()->json(['success' => 'comprobante actualizado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function destroy(Modelscomprobantes $comprobante)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloComprobantes);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        DB::beginTransaction();
        try {
            $comprobante->delete();
            DB::commit();
            return response()->json(['success' => 'comprobante eliminado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
