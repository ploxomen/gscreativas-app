<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ventas extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['fechaVenta','tipoComprobanteFk','serieComprobante','numeroComprobante','clienteFk','metodoPago','cuentaBancaria','billeteraDigital','numeroOperacion','metodoEnvio','aCredito','criditoPagado','subTotal','igvTotal','descuentoTotal','envio','total','montoPagado','vuelto'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    public function scopeListaVentas()
    {
        return DB::table($this->table . " AS v")->select("v.id","cb.comprobante","c.nombreCliente","v.metodoPago","v.metodoEnvio","v.subTotal","v.envio","v.igvTotal","v.descuentoTotal","v.total","v.estado")->selectRaw("LPAD(v.id,5,'0') AS nroVenta,CONCAT(v.serieComprobante,' - ',v.numeroComprobante) AS nroComprobante,DATE_FORMAT(v.fechaVenta,'%d/%m/%Y') AS fechaVenta")->join("clientes AS c","c.id","=","v.clienteFk")->join("comprobantes AS cb","v.tipoComprobanteFk","=","cb.id")->get();
    }

}
