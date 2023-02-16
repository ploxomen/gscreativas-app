<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Area as ModelsArea;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class Area extends Controller
{
    public function viewArea(Request $request): View
    {
        return view("intranet.users.area");
    }
    public function accionesArea(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'error en la consulta']);
        }
        switch ($request->accion) {
            case 'obtener':
                $areas = ModelsArea::all();
                return DataTables::of($areas)->toJson();
                break;
            case 'mostarEditar':
                $area = ModelsArea::find($request->area);
                return response()->json(['success' => $area]);
                break;
            case 'nuevaArea':
                ModelsArea::create(['nombreArea' => $request->area]);
                return response()->json(['success' => 'área agregada correctamente']);
                break;
            case 'editarArea':
                ModelsArea::where('id', $request->areaId)->update(['nombreArea' => $request->area]);
                return response()->json(['success' => 'área actualizada correctamente']);
                break;
        }
    }
}
