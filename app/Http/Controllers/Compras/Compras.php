<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Compras as ModelsCompras;
use App\Models\ComprasDetalle;
use App\Models\Comprobantes;
use App\Models\Productos;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
    public function consultarProductos(Productos $producto, Request $request)
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloNuevaCompra);
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        return response()->json(['producto' => $producto]);
    }
    public function indexHistorialProducto()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest('admin.compras.historial');
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $productos = Productos::where(['estado' => 1])->get();
        return view("intranet.compras.miHistorialCompra", compact("modulos", "productos"));
    }
    public function obtenerHistorial(Request $request)
    {
        $accessModulo = $this->usuarioController->validarXmlHttpRequest('admin.compras.historial');
        if (isset($accessModulo['session'])) {
            return response()->json($accessModulo);
        }
        $productos = ModelsCompras::historialPrecios($request->productos);
        return DataTables::of($productos)->toJson();
    }
    public function listaComprasTotales()
    {
        $accessModulo = $this->usuarioController->validarXmlHttpRequest('admin.compras.mis.compras');
        if (isset($accessModulo['session'])) {
            return response()->json($accessModulo);
        }
        $compras = ModelsCompras::with("proveedor:id,nombre_proveedor")->select("id","proveedorFk","igv","importe","nroComprobante","total")->selectRaw("LPAD(id,5,'0') AS nroCompra,DATE_FORMAT(fechaComprobante,'%d/%m/%Y') AS fechaComp")->where(['estado' => 1])->get();
        return DataTables::of($compras)->toJson();
    }
    public function eliminarCompraCompleta($compra)
    {
        $accessModulo = $this->usuarioController->validarXmlHttpRequest('admin.compras.mis.compras');
        if (isset($accessModulo['session'])) {
            return response()->json($accessModulo);
        }
        ModelsCompras::find($compra)->productos()->detach();
        ModelsCompras::find($compra)->delete();
        return response()->json(['success' => 'compra eliminado correctamente']);
    }
    public function eliminarProductoCompra(Request $request)
    {
        $accessModulo = $this->usuarioController->validarXmlHttpRequest('admin.compras.mis.compras');
        if (isset($accessModulo['session'])) {
            return response()->json($accessModulo);
        }
        DB::beginTransaction();
        try {
            $detalleCompras = ComprasDetalle::where(['compraFk' => $request->compra]);
            if($detalleCompras->count() === 1){
                return response()->json(['alerta' => 'La compra debe tener como mínimo un producto']);
            }
            ComprasDetalle::where(['compraFk' => $request->compra,'productoFk' => $request->producto])->delete();
            $total = 0;
            foreach ($detalleCompras->get() as $dcompra) {
                $total += $dcompra->importe;
            }
            ModelsCompras::find($request->compra)->update(['total' => $total, 'igv' => ($total * 0.18), 'importe' => ($total - ($total * 0.18))]);
            DB::commit();
            return response()->json(['success' => 'producto eliminado correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function agregarModificarCompra(Request $request)
    {
        $accessModulo = $this->usuarioController->validarXmlHttpRequest('admin.compras.mis.compras');
        if (isset($accessModulo['session'])) {
            return response()->json($accessModulo);
        }
        DB::beginTransaction();
        try {
            $compra = ModelsCompras::find($request->compra);
            $compra->update($request->only("proveedorFk", "comprobanteFk", "nroComprobante", "fechaComprobante"));
            $total = 0;
            for ($i = 0; $i < count($request->producto); $i++) {
                $cantidad = isset($request->cantidad[$i]) ? $request->cantidad[$i] : 1;
                $precio = isset($request->precio[$i]) ? $request->precio[$i] : 0.1;
                $importe = isset($request->precio[$i]) && isset($request->cantidad[$i]) ? $request->precio[$i] * $request->cantidad[$i] : 0.1;
                $detalleCompra = ComprasDetalle::where(['compraFk' => $request->compra,'productoFk' => $request->producto[$i]])->first();
                if(empty($detalleCompra)){
                    ComprasDetalle::create(['compraFk' => $request->compra,'productoFk' => $request->producto[$i],'cantidad' => $cantidad,'importe' => $importe,'precio' => $precio]);
                }else{
                    $detalleCompra->update(['cantidad' => $cantidad, 'importe' => $importe, 'precio' => $precio]);
                }
                $total += $importe;
            }
            $compra->update(['total' => $total, 'igv' => ($total * 0.18), 'importe' => ($total - ($total * 0.18))]);
            DB::commit();
            return response()->json(['success' => 'compra modificada correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function obtenerEditar($compra)
    {
        $accessModulo = $this->usuarioController->validarXmlHttpRequest('admin.compras.mis.compras');
        if (isset($accessModulo['session'])) {
            return response()->json($accessModulo);
        }
        $compras = ModelsCompras::select("id","nroComprobante", "proveedorFk", "comprobanteFk", "fechaComprobante","importe","igv","total")->find($compra);
        $detalle = ModelsCompras::find($compra)->productos()->select("urlImagen","nombreProducto")->get();
        return response()->json(['compra' => $compras,'detalleCompra' => $detalle]);
    }
    public function listaComprasIndex()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest('admin.compras.mis.compras');
        if (isset($verif['session'])) {
            return redirect()->route("home");
        }
        $modulos = $this->usuarioController->obtenerModulos();
        $comprobantes = Comprobantes::where('estado', 1)->get();
        $proveedores = Proveedores::where(['estado' => 1])->get();
        $productos = Productos::where(['estado' => 1])->get();
        return view("intranet.compras.misCompras", compact("modulos", "comprobantes", "proveedores", "productos"));

    }
    public function storeCompra(Request $request)
    {
        $accessModulo = $this->usuarioController->validarXmlHttpRequest($this->moduloNuevaCompra);
        if (isset($accessModulo['session'])) {
            return response()->json($accessModulo);
        }
        $datos = $request->only("proveedorFk", "comprobanteFk", "nroComprobante", "fechaComprobante");
        $datos['estado'] = 1;
        DB::beginTransaction();
        try {
            $compra = ModelsCompras::create($datos);
            $total = 0;
            for ($i = 0; $i < count($request->productos); $i++) {
                $cantidad = isset($request->cantidad[$i]) ? $request->cantidad[$i] : 1;
                $precio = isset($request->precio[$i]) ? $request->precio[$i] : 0.1;
                $importe = isset($request->precio[$i]) && isset($request->cantidad[$i]) ? $request->precio[$i] * $request->cantidad[$i] : 0.1;
                Productos::find($request->productos[$i])->increment('cantidad', $cantidad);
                $compra->productos()->attach([
                    $request->productos[$i] => [
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'importe' => $importe
                    ]
                ]);
                $total += $importe;
            }
            $compra->update(['total' => $total, 'igv' => ($total * 0.18), 'importe' => ($total - ($total*0.18))]);
            DB::commit();
            return response()->json(['success' => 'Compra registrada correctamente']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
       
    }
}
