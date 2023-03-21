<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Clientes;
use App\Models\Comprobantes;
use App\Models\Productos;
use App\Models\TipoDocumento;
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
        $comprobantes = Comprobantes::where('estado',1)->get();
        $numeroComprobante = $comprobantes->find(1);
        $tiposDocumentos = TipoDocumento::where('estado',1)->get(); 
        $clientes = Clientes::where('estado',1)->get();
        $productos = Productos::where('estado',1)->get();
        return view("intranet.ventas.agregar", compact("modulos","comprobantes","numeroComprobante","clientes","tiposDocumentos","productos"));
    }
    public function verProductoAsignarVenta(Productos $producto)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloGerarVentas);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        if($producto->estado != 1 || $producto->cantidad === 0){
            return response()->json(['alerta' => 'El porducto ' . $producto->nombreProducto . ' ha sido descontinuado o no cuenta con stock suficiente']);
        }
        $producto->urlProductos = !empty($producto->urlImagen) ? route("urlImagen",["productos",$producto->urlImagen]) : null;
        return response()->json(['producto' => $producto->makeHidden("fechaCreada","fechaActualizada")]);
    }
}
