<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'caja';
    protected $fillable = ['usuarioFk','fecha_caja','fecha_hr_inicio','fecha_hr_termino','importe_total','igv_total','envio_total','descuento_total','total'];

}
