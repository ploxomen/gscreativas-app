<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Modulo;
use App\Models\Rol as ModelsRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class Rol extends Controller
{
    private $userControler = null;
    function __construct()
    {
        $this->userControler = new Usuario();
    }
    public function viewRol(Request $request) : View
    {
        $modulos = $this->userControler->obtenerModulos();
        $modulosLista = Modulo::with("grupos")->orderBy("grupoFk")->get();
        // dd($modulosLista);
        return view("intranet.users.roles",compact("modulos", "modulosLista"));
    }
    public function accionesRoles(Request $request)
    {
        if(!$request->ajax()){
            return response()->json(['error' => 'error en la consulta']);
        }
        switch ($request->accion) {
            case 'obtener':
                $roles = ModelsRol::all();
                return DataTables::of($roles)->toJson();
            break;
            case 'mostarEditar':
                $rol = ModelsRol::find($request->rol);
                return response()->json(['success' => $rol]);
            break;
            case 'nuevoRol':
                ModelsRol::create(['nombreRol' => $request->rol, 'claseIcono' => $request->icono]);
                return response()->json(['success' => 'rol agregado correctamente']);
            break;
            case 'editarRol':
                ModelsRol::where('id',$request->rolId)->update(['nombreRol' => $request->rol, 'claseIcono' => $request->icono]);
                return response()->json(['success' => 'rol actualizado correctamente']);
            break;
            case 'eliminar':
                $modeloRol = ModelsRol::find($request->rol)->usuarios();
                DB::beginTransaction();
                try {
                    if ($modeloRol->count() > 0) {
                        return response()->json(['alerta' => 'No se puede eliminar el rol, primero elimine los usuarios asociados a el.']);
                    }
                    $modeloRol->detach();
                    ModelsRol::find($request->rol)->delete();
                    DB::commit();
                    return response()->json(['success' => 'rol eliminado correctamente']);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(['error' => $th->getMessage(), 'codigo' => $th->getCode()]);
                }
            break;
        }
    }
}
