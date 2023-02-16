<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Rol;
use Illuminate\Http\Request;

class Usuario extends Controller
{
    public function agregarUsuario()
    {
        $areas = Area::get();
        return view('intranet.users.index',['areas' => $areas]);
    }
    public function getArea(Request $request)
    {
        try {
            $result = Rol::getRolArea($request->post('id_area'));
            return response()->json(['success' => $result]);
            
        } catch (\Throwable $th) {
           return response()->json(['error'=>$th->getMessage()]);
        }
    }
    public function listarUsuarios()
    {
        return view('intranet.users.lista');
    }
}
