<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VentaDetalle extends Model
{
    protected $table = 'ventas_detalle';
    protected $fillable = ['ventaFk','productoFk','costo','cantidad','importe','igv','descuento','total','fechaPerecedero'];
    public $timestamps = false;

    public function scopeDetalleVenta($query, int $venta)
    {
        $detalles = DB::table($this->table ." AS vd")->select("vd.productoFk","vd.id","p.nombreProducto","p.urlImagen","vd.costo","vd.cantidad","vd.descuento", "vd.importe", "vd.fechaPerecedero","vd.productoFk")->selectRaw("DATE_FORMAT(vd.fechaPerecedero,'%d/%m/%Y') AS textPerecedero")->join("productos AS p","vd.productoFk","=","p.id")->where('vd.ventaFk',$venta)->get();
        foreach ($detalles as $detalle) {
            $detalle->perecederos = Perecedero::select("vencimiento")->selectRaw("DATE_FORMAT(vencimiento,'%d/%m/%Y') AS verPerecedero")->where(['productoFk' => $detalle->productoFk,'estado' => 1])->get();
        }
        return $detalles;
    }
}
