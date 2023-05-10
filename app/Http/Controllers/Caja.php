<?php

namespace App\Http\Controllers;

use App\Models\Caja as ModelsCaja;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Caja extends Controller
{
    private $usuarioController;
    private $moduloAbrirCaja = "admin.caja.abrir";
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function abrirCaja()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAbrirCaja);
        if(isset($verif['session'])){
            return response()->json(['session' => true]); 
        }
        $fechaActual = date("Y-m-d");
        $fechaHrActual = now();
        $usuario = Auth::id();
        ModelsCaja::whereIn("estado",[1,2])->update(['estado' => 0]);
        ModelsCaja::create(['usuarioFk' => $usuario, 'fecha_caja' => $fechaActual, 'fecha_hr_inicio' => $fechaHrActual]);
        return response()->json(['success' => 'Caja abierta satisfactoriamente']);
    }
    public function cerrarCaja()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAbrirCaja);
        if (isset($verif['session'])) {
            return response()->json(['session' => true]);
        }
        $fechaHrActual = now();
        $cajaAbierta = ModelsCaja::whereNull('fecha_hr_termino')->where("fecha_hr_inicio","<", $fechaHrActual)->first();
        if(empty($cajaAbierta)){
            return response()->json(['error' => 'No se encontró una caja abierta para cerrar']);
        }
        $fechaInicio = date("Y-m-d",strtotime($cajaAbierta->fecha_hr_inicio));
        $fechaFin = date("Y-m-d", strtotime($fechaHrActual));
        $ventas = Ventas::whereNull("cajaFk")->whereBetween("fechaVenta",[$fechaInicio,$fechaFin])->get();
        $total = 0;
        $igv = 0;
        $descuento = 0;
        $envio = 0;
        $importe = 0;
        DB::beginTransaction();
        try {
            foreach ($ventas as $venta) {
                $total += $venta->total;
                $igv += $venta->igvTotal;
                $descuento += $venta->descuentoTotal;
                $envio += $venta->envio;
                $importe += $venta->subTotal;
                $venta->update(["cajaFk" => $cajaAbierta->id]);
            }
            $cajaAbierta->update(['fecha_hr_termino' => $fechaHrActual, 'importe_total' => $importe, 'igv_total' => $igv, 'envio_total' => $envio, 'descuento_total' => $descuento, 'total' => $total,'estado' => 2]);
            DB::commit();
            return response()->json(['success' => 'Caja cerrada satisfactoriamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
        
    }
    public function indexAbrirCaja()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloAbrirCaja);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $diaActual = date("Y-m-d");
        $caja = ModelsCaja::where(['fecha_caja'=>$diaActual])->whereIn('estado',[1,2])->first();
        $fechaLarga = (new Helpers)->fechaCompleta($diaActual);
        return view("intranet.caja.nueva",compact("modulos","caja","fechaLarga")); 
    }
    public function obtenerEstadoCaja()
    {
        $diaActual = date("Y-m-d");
        $caja = ModelsCaja::where(['fecha_caja' => $diaActual, 'estado' => 1])->first();
        if(empty($caja) || (!empty($caja) && !is_null($caja->fecha_hr_inicio) && !is_null($caja->fecha_hr_termino))){
            return 'caja cerrada';
        }
        if(!empty($caja) && !is_null($caja->fecha_hr_inicio)){
            return 'caja abierta';
        }
        return 'no establecido';
    }
}
