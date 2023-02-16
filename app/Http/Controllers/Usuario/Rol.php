<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Rol as ModelsRol;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class Rol extends Controller
{
    public function viewRol(Request $request) : View
    {
        return view("intranet.users.roles");
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
        }
    }
}
