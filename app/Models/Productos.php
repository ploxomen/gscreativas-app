<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';
    protected $fillable = ['codigoBarra','nombreProducto','descripcion','cantidad','cantidadMin','precioVenta','precioVentaPorMayor','precioCompra','categoriaFk','marcaFk','presentacionFk','urlImagen','estado','igv'];

    public function marca()
    {
        return $this->belongsTo(Marca::class,'marcaFk');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class,'categoriaFk');
    }
    public function presentacion()
    {
        return $this->belongsTo(Presentacion::class,'presentacionFk');
    }
}
