<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VentaDetalle extends Model
{
    protected $table = 'ventas_detalle';
    protected $fillable = ['ventaFk','productoFk','costo','cantidad','importe','igv','descuento','total','fechaPerecedero'];
    public $timestamps = false;

    public function scopeDetalleVenta(int $venta)
    {
        $detalles = DB::table($this->table ." AS vd")->select("p.nombreProducto","p.urlImagen","vd.costo","vd.cantidad","vd.descuento","dv.importe","dv.fechaPerecedero","vd.productoFk")->selectRaw("DATE_FORMAT(dv.fechaPerecedero,'%d/%m/%Y') AS textPerecedero")->join("producto AS p","vd.productoFk","=","p.id")->where('vd.ventaFk',$venta)->get();
        foreach ($detalles as $detalle) {
            $detalle->perecederos = Perecedero::select("vencimiento")->selectRaw("DATE_FORMAT(vencimiento,'%d/%m/%Y') AS verPerecedero")->where(['productoFk' => $detalle->productoFk,'estado' => 1])->get();
        }
        return $detalles;
    }
}
