<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';
    protected $fillable = ['fechaCotizacion', 'cliente', 'cotizadorUsuario','metodoEnvio', 'tipoPago', 'importe', 'igv', 'descuento', 'envio', 'total', 'estado'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'cotizacion_detalle', 'cotizacionFk' , 'productoFk')->withTimestamps()->withPivot("costo","cantidad","importe", "igv","descuento","total");
    }
    public function cotizador()
    {
        return $this->belongsTo(User::class, 'cotizadorUsuario');
    }
    public function scopeVerCotizacionTabla($query)
    {
        return $query->select("cotizacion.id","cliente","metodoEnvio","tipoPago","importe","igv","descuento","envio","total")->selectRaw("LPAD(cotizacion.id,5,'0') AS nroCotizacion, DATE_FORMAT(fechaCotizacion,'%d/%m/%Y') AS fechaCotizacion,CONCAT(u.nombres,' ',u.apellidos) AS cotizador")
        ->join("usuarios AS u","u.id","=", "cotizacion.cotizadorUsuario")
        ->get();
    }
}
