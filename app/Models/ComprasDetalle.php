<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComprasDetalle extends Model
{
    public $table = "compras_detalle";
    protected $fillable = ['compraFk', 'productoFk', 'cantidad', 'precio', 'importe'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    

}
