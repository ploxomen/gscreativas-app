<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    protected $table = 'presentacion';
    public $timestamps = false;
    protected $fillable = ['nombrePresentacion','siglas'];

    public static function obtenerUnidades()
    {
        return Unidades::all();
    }
}
