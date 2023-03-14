<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perecedero extends Model
{
    protected $table = 'perecederos';
    protected $fillable = ['productoFk','cantidad','vencimiento','estado'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    public function productos()
    {
        return $this->belongsTo(Productos::class,'productoFk');
    }
}
