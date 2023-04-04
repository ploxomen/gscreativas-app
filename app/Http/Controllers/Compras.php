<?php

namespace App\Http\Controllers;

use App\Models\Comprobantes;
use App\Models\Productos;
use App\Models\Proveedores;
use Illuminate\Http\Request;

class Compras extends Controller
{
    private $moduloNuevaCompra = "admin.compras.nueva.compra";
    private $usuarioController;
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function indexNuevaCompra()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloNuevaCompra);
        if(isset($verif['session'])){
            return redirect()->route("home"); 
        }
        $comprobantes = Comprobantes::where('estado',1)->get();
        $proveedores = Proveedores::where(['estado' => 1])->get();
        $productos = Productos::where(['estado' => 1])->get();
        $modulos = $this->usuarioController->obtenerModulos();
        return view("intranet.compras.generarCompra",compact("modulos","comprobantes","proveedores","productos"));
    }
}
