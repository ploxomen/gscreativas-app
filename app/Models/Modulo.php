<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    public $table = "modulo";
    public function roles()
    {
        return $this->belongsToMany(Rol::class,'modulo_roles','moduloFk','rolFk');
    }
    public function grupos()
    {
        return $this->belongsTo(ModuloGrupo::class, 'grupoFk');
    }
}
