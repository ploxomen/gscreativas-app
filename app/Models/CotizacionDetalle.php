<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    protected $table = 'cotizacion_detalle';
    protected $fillable = ['cotizacionFk', 'productoFk', 'costo', 'cantidad', 'importe', 'igv', 'descuento', 'total'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';
}
