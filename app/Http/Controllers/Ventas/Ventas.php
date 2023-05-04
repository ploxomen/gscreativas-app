<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Http\Controllers\Ventas\Comprobantes as VentasComprobantes;
use App\Models\Clientes;
use App\Models\Comprobantes;
use App\Models\Configuracion;
use App\Models\Perecedero;
use App\Models\Productos;
use App\Models\TipoDocumento;
use App\Models\VentaDetalle;
use App\Models\Ventas as ModelsVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class Ventas extends Controller
{
    private $usuarioController;
    private $moduloGerarVentas = "ventas.registrar.index";
    private $moduloMisVentas = "admin.ventas.index";
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
        return response()->json($this->buscarProducto($producto));
    }
    public function verComprobante(Comprobantes $comprobante)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloGerarVentas);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $serie = $comprobante->serie;
        $numero = str_pad($comprobante->inicio + $comprobante->utilizados,strlen($comprobante->fin),"0",STR_PAD_LEFT);
        return response()->json(['comprobanteSerie' => $serie , 'comprobanteNumero' => $numero]);
    }
    public function verCliente(Clientes $cliente)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloGerarVentas);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $newCliente = $cliente->select("tipoDocumento","nroDocumento")->find($cliente->id);
        return response()->json(['cliente' => $newCliente]);
    }
    public function listaMisVentas()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloMisVentas);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $listaVentas = ModelsVentas::listaVentas();
        return DataTables::of($listaVentas)->toJson();
    }
    public function verMisVentas()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloMisVentas);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $comprobantes = Comprobantes::where('estado',1)->get();
        $numeroComprobante = $comprobantes->find(1);
        $tiposDocumentos = TipoDocumento::where('estado',1)->get(); 
        $clientes = Clientes::where('estado',1)->get();
        $productos = Productos::where('estado',1)->get();
        return view("intranet.ventas.misVentas", compact("modulos","comprobantes","numeroComprobante","clientes","tiposDocumentos","productos"));

    }
    public function verComprobanteVenta($venta)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloGerarVentas);
        $verif2 = $this->usuarioController->validarXmlHttpRequest($this->moduloMisVentas);
        if (isset($verif['session']) && isset($verif2['session'])) {
            return redirect()->route("home");
        }
        $customPaper = array(0, 0, 867.00, 283.80);
        $ventas = ModelsVentas::find($venta);
        $ventas->detalleVentas = VentaDetalle::detalleVenta(intval($venta));
        $configuracion = Configuracion::all();
        return Pdf::loadView("intranet.ventas.reportes.comprobanteVenta",compact("ventas","configuracion"))->setPaper($customPaper, "landscape")->stream();
    }
    public function registrarVenta(Request $request, VentasComprobantes $comprobanteVenta)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloGerarVentas);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $venta = $request->only("tipoComprobanteFk","fechaVenta","fechaVenta","metodoPago","metodoEnvio","envio","cuentaBancaria","numeroOperacion","billeteraDigital","montoPagado","clienteFk");
        $detalleVenta = json_decode($request->lisProducos);
        DB::beginTransaction();
        try {
            $comprobante = Comprobantes::find($request->tipoComprobanteFk);
            $venta['serieComprobante'] = $comprobante->serie;
            $venta['numeroComprobante'] = str_pad($comprobante->inicio + $comprobante->utilizados,strlen($comprobante->fin),"0",STR_PAD_LEFT);
            $venta['aCredito'] = $request->metodoPago == "A CREDITO" ? 1 : 0;
            $dbVenta = ModelsVentas::create($venta);
            $subTotal = 0;
            $igvTotal = 0;
            $descuentoTotal = 0;
            foreach ($detalleVenta as $dVenta) {
                $subTotal = $subTotal + $dVenta->subtotal;
                $igvTotal = $igvTotal + (empty($dVenta->igv) ? 0 : ($dVenta->subtotal * 0.18)); 
                $descuentoTotal = $descuentoTotal + $dVenta->descuento; 
                $producto = Productos::find($dVenta->idProducto);
                if($dVenta->vencimientos != '0'){
                    $vencimiento = Perecedero::where(["vencimiento" => $dVenta->vencimientos,'productoFk' => $producto->id])->first();
                    if($vencimiento->cantidad < $dVenta->cantidad){
                        DB::rollBack();
                        return response()->json(['alerta' => "El producto " . $producto->nombreProducto . " con fecha de vencimiento " . date("d/m/Y",strtotime($vencimiento->vencimiento)) . " ha superado el stock de " . $producto->cantidad . " " . $producto->presentacion->siglas .", por favor disminuya la cantidad o elimine el producto"]);
                    }
                    $disminuir = $vencimiento->cantidad - $dVenta->cantidad;
                    $vencimiento->update(['cantidad' => $disminuir]);
                    if($disminuir <= 0){
                        $vencimiento->delete();
                    }
                }else{
                    $perecedero = intval($producto->perecederos()->sum("cantidad"));
                    $cantidad = $producto->cantidad - $perecedero;
                    if($cantidad < $dVenta->cantidad){
                        DB::rollBack();
                        return response()->json(['alerta' => "El producto " . $producto->nombreProducto .  " ha superado el stock de " . $producto->cantidad . " " . $producto->presentacion->siglas .", por favor disminuya la cantidad o elimine el producto"]);
                    }
                }
                $disminuir = $producto->cantidad - $dVenta->cantidad;
                $producto->update(['cantidad' => $disminuir]);
                VentaDetalle::create(['ventaFk' => $dbVenta->id,'productoFk' => $dVenta->idProducto, 'costo' => $dVenta->precio,'cantidad' => $dVenta->cantidad,'importe' => $dVenta->subtotal,'igv' => empty($dVenta->igv) ? 0 : $dVenta->subtotal * 0.18,'descuento' => $dVenta->descuento, 'total' => $dVenta->subtotal - $dVenta->descuento,'fechaPerecedero' => empty($dVenta->vencimientos) ? null : $dVenta->vencimientos]);
            }
            $total = $subTotal + floatval($request->envio) - $descuentoTotal;
            $dbVenta->update(['subTotal' => $subTotal,'igvTotal' => $igvTotal,'descuentoTotal' => $descuentoTotal,'total' => $total, 'vuelto' => $request->metodoPago != "A CREDITO" ? floatval($request->montoPagado) - $total : 0]);
            $comprobanteVenta->incrementarComprobante($request->tipoComprobanteFk);
            DB::commit();
            return response()->json(['success' => $dbVenta->id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage(),'codigo' => $th->getCode(),'line' => $th->getLine()]);
        }
    }
    public function verVentasParaEditar($venta)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloMisVentas);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $ventas = ModelsVentas::with("clientes:id,tipoDocumento,nroDocumento")->find($venta);
        // dd($venta);
        $ventas->detalleVentas = VentaDetalle::detalleVenta(intval($venta));
        return response()->json(['venta' => $ventas]);
    }
    public function verProductoMisVentas(Productos $producto)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloMisVentas);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        return response()->json($this->buscarProducto($producto));
    }
    public function buscarProducto($producto)
    {
        if($producto->estado != 1 || $producto->cantidad === 0){
            return ['alerta' => 'El porducto ' . $producto->nombreProducto . ' ha sido descontinuado o no cuenta con stock suficiente'];
        }
        $producto->urlProductos = !empty($producto->urlImagen) ? route("urlImagen",["productos",$producto->urlImagen]) : null;
        $perecederos = Perecedero::select("id","cantidad","vencimiento")->where(['productoFk'=>$producto->id,'estado' => 1]);
        $nuevoPerecedero = [];
        if($perecederos->sum("cantidad") != $producto->cantidad || $perecederos->sum("cantidad") === 0){
            $nuevoPerecedero[] = [
                'fecha' => 'Ninguno',
                'valor' => 0
            ];
        }
        foreach ($perecederos->get() as $perecedero) {
            $nuevoPerecedero[] = [
                'fecha' => date('d/m/Y',strtotime($perecedero->vencimiento)),
                'valor' => $perecedero->vencimiento
            ];
        }
        return ['producto' => $producto->makeHidden("fechaCreada","fechaActualizada"),'perecederos' => $nuevoPerecedero];
    }
}
