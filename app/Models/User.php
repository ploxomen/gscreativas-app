<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = "usuarios";
    const UPDATED_AT = "fechaActualizada";
    const CREATED_AT = "fechaCreada";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'contrasena',
        'correo',
        'tipoDocumento',
        'nroDocumento',
        'telefono',
        'celular',
        'direccion',
        'fechaCumple',
        'sexo',
        'estado',
        'areaFk'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'contrasena',
        'recordarToken',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class,'areaFk');
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class,'usuario_rol','usuarioFk','rolFk');
    }
}
