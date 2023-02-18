<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Rol;
use App\Models\User;
use App\Models\UsuarioRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
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
            case 'mostrarEditar':
                $usuario = User::with('roles:id')->select("nombres", "apellidos", "celular", "estado", "correo", "usuarios.id", "areaFk","tipoDocumento","nroDocumento","telefono","celular","direccion","fechaCumple","sexo")->where("usuarios.id", $request->idUsuario)->first();
                return response()->json(['success' => $usuario]);
            break;
            case 'editar':
                $usuario = User::find($request->idUsuario);
                DB::beginTransaction();
                try {
                    $usuario->roles()->detach();
                    foreach ($request->roles as $rol) {
                        $usuario->roles()->attach($rol);
                    }
                    $datos = $request->all();
                    unset($datos['acciones']);
                    unset($datos['roles']);
                    $usuario->update($datos);
                    DB::commit();
                    return response()->json(['success' => 'Usuario actualizado con éxito']);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(['error' => $th->getMessage(), 'codigo' => $th->getCode()]);
                }
            break;
            case 'eliminar':
                $usuario = User::find($request->idUsuario);
                DB::beginTransaction();
                try {
                    $usuario->roles()->detach();
                    $usuario->delete();
                    DB::commit();
                    return response()->json(['success' => 'Usuario eliminado con éxito']);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(['error' => $th->getMessage(), 'codigo' => $th->getCode()]);
                }
            break;
        }
    }
    public function listarUsuarios()
    {
        $roles = Rol::all();
        $areas = Area::all();
        return view('intranet.users.lista',compact("roles","areas"));
    }
    public function retaurarContra() : View
    {
        return view('cambioContra');
    }
    public function loginView() : View
    {
        return view('login');
    }
}
