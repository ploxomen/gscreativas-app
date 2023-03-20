<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use Illuminate\Http\Request;

class Ventas extends Controller
{
    private $usuarioController;
    private $moduloGerarVentas = "ventas.registrar.index";
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function indexRegistroVentas()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloGerarVentas);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        return view("intranet.ventas.clientes", compact("modulos", "tiposDocumentos"));
    }
}
