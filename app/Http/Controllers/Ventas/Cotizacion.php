<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Configuracion;
use App\Models\Cotizacion as ModelsCotizacion;
use App\Models\CotizacionDetalle;
use App\Models\Productos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Cotizacion extends Controller
{
    private $usuarioController;
    private $moduloAgregarCotizacion = "cotizacion.registrar.index";
    private $moduloMisCotizaciones = "admin.cotizaciones.index";
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function indexNuevaCotizacion()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAgregarCotizacion);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $productos = Productos::where('estado', 1)->get();
        return view("intranet.cotizacion.agregar", compact("modulos", "productos"));
    }
    public function obtenerProducto(Productos $producto)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAgregarCotizacion);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $ventas = new Ventas();
        return response()->json($ventas->buscarProducto($producto));
    }
    public function comprobanteCotizacion(ModelsCotizacion $cotizacion)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAgregarCotizacion);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $configuracion = Configuracion::all();
        return Pdf::loadView("intranet.cotizacion.reportes.comprobanteCotizacion", compact("cotizacion","configuracion"))->stream();
    }
    public function verCotizacionesAdminIndex()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloMisCotizaciones);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        return view("intranet.cotizacion.listarAdmin", compact("modulos"));
    }
    public function verCotizacionesAdmin()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloMisCotizaciones);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $cotizaciones = ModelsCotizacion::verCotizacionTabla();
        return DataTables::of($cotizaciones)->toJson();
    }
    public function eliminarCotizacion(ModelsCotizacion $cotizacion)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloMisCotizaciones);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $cotizacion->productos()->detach();
        $cotizacion->delete();
        return response()->json(['success' => 'cotización eliminada correctamente']);
    }
    public function registrarCotizacion(Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAgregarCotizacion);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $cotizacion = $request->only("cliente", "metodoEnvio", "envio");
        $cotizacion['tipoPago'] = $request->has("tipoPago") ? "AL CONTADO" : "A CREDITO";
        $cotizacionDetalles = json_decode($request->lisProductos);
        $fueraDeStock = [];
        $subTotal = 0;
        $igvTotal = 0;
        $descuentoTotal = 0;
        foreach ($cotizacionDetalles as $cotizacionDetalle) {
            $producto = Productos::find($cotizacionDetalle->idProducto);
            if($producto->cantidad < $cotizacionDetalle->cantidad){
                $fueraDeStock[] = [
                    'producto' => $producto->nombreProducto,
                    'cantidad' => $cotizacionDetalle->cantidad,
                    'cantidadMaxima' => $producto->cantidad
                ];
            }
            $subTotal = $subTotal + $cotizacionDetalle->subtotal;
            $igvTotal = $igvTotal + (empty($cotizacionDetalle->igv) ? 0 : ($cotizacionDetalle->subtotal * 0.18));
            $descuentoTotal = $descuentoTotal + $cotizacionDetalle->descuento; 
        }
        if(count($fueraDeStock) > 0){
            return response()->json(['fueraStock' => $fueraDeStock]);
        }
        DB::beginTransaction();
        try {
            $cotizacion['importe'] = $subTotal;
            $cotizacion['fechaCotizacion'] = now();
            $cotizacion['igv'] = $igvTotal;
            $cotizacion['descuento'] = $descuentoTotal;
            $cotizacion['total'] = $subTotal + floatval($request->envio) - $descuentoTotal;
            $cotizacion['cotizadorUsuario'] = Auth::id();
            $cotizacionDb = ModelsCotizacion::create($cotizacion);
            foreach ($cotizacionDetalles as $cotizacionDetalle) {
                CotizacionDetalle::create([
                    'cotizacionFk' => $cotizacionDb->id,
                    'productoFk' => $cotizacionDetalle->idProducto,
                    'costo' => $cotizacionDetalle->precio,
                    'cantidad' => $cotizacionDetalle->cantidad,
                    'importe' => $cotizacionDetalle->precio * $cotizacionDetalle->cantidad,
                    'igv' => ($cotizacionDetalle->precio * $cotizacionDetalle->cantidad) * 0.18,
                    'descuento' => $cotizacionDetalle->descuento,
                    'total' => ($cotizacionDetalle->precio * $cotizacionDetalle->cantidad) - $cotizacionDetalle->descuento
                ]);
            }
            DB::commit();
            return response()->json(['success' => $cotizacionDb->id]);
        } catch (\Throwable $th) {
           DB::rollBack();
           return response()->json(['error' => $th->getMessage()]);
        }

    }
}
