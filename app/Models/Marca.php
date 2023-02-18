<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marca';
    public $timestamps = false;
    protected $fillable = ['nombreMarca'];

    public static function obtenerMarcas(){
        return Marca::orderBy('nombreMarca','asc')->get();
    }
    public static function agregarMarca($valor)
    {
        return Marca::insert($valor);
    }
    public static function modificarMarca($id,$valor)
    {
        return Marca::where(['id' => $id])->update($valor);
    }
}
