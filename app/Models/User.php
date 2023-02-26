<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{

    public $table = "usuarios";
    const UPDATED_AT = "fechaActualizada";
    const CREATED_AT = "fechaCreada";
    protected $rememberTokenName = 'recordarToken';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'password',
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
        'password',
        'recordarToken',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class,'areaFk');
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class,'usuario_rol','usuarioFk','rolFk')->withPivot('activo')->withTimestamps();
    }
}
