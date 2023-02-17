<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Rol;
use App\Models\User;
use App\Models\UsuarioRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class Usuario extends Controller
{
    public function agregarUsuario()
    {
        $areas = Area::get();
        return view('intranet.users.index',['areas' => $areas]);
    }
    public function getArea(Request $request)
    {
        if(!$request->ajax()){
            return response()->json(['error' => 'error en la petición']);
        }
        switch ($request->acciones) {
            case 'agregar':
                $repetidos = User::where(['correo' => $request->correo])->count();
                if ($repetidos > 0) {
                    return response()->json(['alerta' => 'El correo ' . $request->email . ' ya se encuentra registrado, por favor intente con otro correo']);
                }
                $datos = $request->all();
                $datos['contrasena'] = Hash::make($datos['contrasena']);
                $datos['estado'] = 2;
                unset($datos['acciones']);
                DB::beginTransaction();
                try {
                    $usuario = User::create($datos);
                    foreach($datos['roles'] as $rol){
                        UsuarioRol::create(['rolFk' => $rol,'usuarioFk' => $usuario->id]);
                    }
                    DB::commit();
                    return response()->json(['success' => 'Usuario creado correctamente, recuerde que su contraseña temporal es ' . $request->contrasena]);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(['error' => $th->getMessage(),'codigo' => $th->getCode()]);
                }
            break;
            case 'obtener' :
                $usuarios = new User();


                // $usuarios = User::with('roles')->get();
                // foreach ($usuarios as $usuario) {
                //     dd($usuario->roles->nombreRol);
                // }
                // dd(User::where('estado',2)->roles()->get());
                
                if($request->rol != 'todos'){
                    $usuarios = Rol::find($request->rol)->usuarios()->with('area:id,nombreArea')->select("nombres","apellidos","celular","estado","correo","usuarios.id","areaFk");
                }else{
                    $usuarios = User::with('area:id,nombreArea')->select("nombres","apellidos","celular","estado","correo","usuarios.id","areaFk");
                }
                if($request->area != 'todos'){
                    $usuarios = $usuarios->where('usuarios.areaFk',$request->area);
                }
                return DataTables::of($usuarios->get())->addColumn('apellidosNombres',function(User $usuario){
                    return $usuario->nombres . ' ' . $usuario->apellidos;
                })->toJson();
            break;
            default:
            
            break;
        }
            
        
    }
    public function listarUsuarios()
    {
        $roles = Rol::all();
        $areas = Area::all();
        return view('intranet.users.lista',compact("roles","areas"));
    }
}
