<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $table = 'ventas_detalle';
    protected $fillable = ['ventaFk','productoFk','costo','cantidad','importe','igv','descuento','total'];
    public $timestamps = false;
}
