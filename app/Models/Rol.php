<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public $table = "rol";
    protected $fillable = ['nombreRol','claseIcono'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    protected function serializeDate($date)
    {
        return $date->format('d/m/Y h:i a');
    }
    public function usuarios()
    {
        return $this->belongsToMany(User::class,'usuario_rol','rolFk','usuarioFk');
    }
}
