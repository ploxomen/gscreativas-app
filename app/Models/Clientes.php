<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    public $table = "clientes";
    protected $fillable = ['nombreCliente','tipoDocumento','nroDocumento','telefono','celular','correo','direccion','limteCredito','estado'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class,'tipoDocumento');
    }
    public function usuarios()
    {
        return $this->belongsTo(TipoDocumento::class,'tipoDocumento');
    }
    public function ventas()
    {
        return $this->hasMany(Ventas::class, 'clienteFk');
    }
    
}
