<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobantes extends Model
{
    public $table = "comprobantes";
    protected $fillable = ['comprobante', 'serie', 'inicio', 'fin', 'disponibles', 'utilizados', 'estado'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';
}
