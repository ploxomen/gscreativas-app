<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compras extends Model
{
    public $table = "compras";
    protected $fillable = ['proveedorFk', 'comprobanteFk', 'nroComprobante', 'fechaComprobante', 'tipoCompra','estado','importe','igv','total'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'compras_detalle', 'compraFk', 'productoFk')->withTimestamps()->withPivot("cantidad","precio","importe");
    }
    public function scopeComprasMes($query)
    {
        return $query->where('estado', 1)->whereYear('fechaComprobante', date('Y'))->whereMonth('fechaComprobante', date('m'))->sum('total');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedorFk');
    }
    public function scopeHistorialPrecios($query, $idProducto)
    {
        return DB::table($this->table . " AS c")->select("pe.nombre_proveedor","p.nombreProducto", "cd.precio", "m.nombreMarca", "pre.nombrePresentacion")
        ->selectRaw("LPAD(c.id,5,'0') AS nroCompra,DATE_FORMAT(c.fechaComprobante,'%d/%m/%Y') AS fechaComp")
        ->join("compras_detalle AS cd", "cd.compraFk", "=", "c.id")
        ->join("proveedores AS pe","pe.id","=", "c.proveedorFk")
        ->join("productos AS p", "cd.productoFk", "=", "p.id")
        ->join("presentacion AS pre", "pre.id", "=", "p.presentacionFk")
        ->join("marca AS m", "m.id", "=", "p.marcaFk")
        ->where('p.id', $idProducto)
        ->orderByDesc("c.fechaComprobante")
        ->get();
    }
}
