<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['fechaVenta','tipoComprobanteFk','serieComprobante','numeroComprobante','clienteFk','metodoPago','cuentaBancaria','billeteraDigital','numeroOperacion','metodoEnvio','aCredito','criditoPagado','subTotal','igvTotal','descuentoTotal','envio','total','montoPagado','vuelto'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';
}
