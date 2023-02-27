<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    public function marca()
    {
        return $this->belongsTo(Marca::class,'marcaFk');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class,'categoriaFk');
    }
}
