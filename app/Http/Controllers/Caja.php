<?php

namespace App\Http\Controllers;

use App\Models\Caja as ModelsCaja;
use Illuminate\Http\Request;

class Caja extends Controller
{
    private $usuarioController;
    private $moduloAbrirCaja = "admin.caja.abrir";
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function indexAbrirCaja()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAbrirCaja);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $diaActual = date("Y-m-d");
        $caja = ModelsCaja::where('fecha_caja',$diaActual)->first();
        $fechaLarga = (new Helpers)->fechaCompleta($diaActual);
        return view("intranet.caja.nueva",compact("modulos","caja","fechaLarga")); 
    }
    public function obtenerEstadoCaja()
    {
        $diaActual = date("Y-m-d");
        $caja = ModelsCaja::where('fecha_caja',$diaActual)->first();
        if(empty($caja) || (!empty($caja) && !is_null($caja->fecha_hr_inicio) && !is_null($caja->fecha_hr_termino))){
            return 'caja cerrada';
        }
        if(!empty($caja) && !is_null($caja->fecha_hr_inicio)){
            return 'caja abierta';
        }
        return 'no establecido';
    }
}
