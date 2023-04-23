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
    public function perecederos()
    {
        return $this->hasMany(Perecedero::class,'productoFk');
    }
    public function compras()
    {
        return $this->belongsToMany(Compras::class, 'compras_detalle', 'productoFk', 'compraFk')->withTimestamps();
    }
    public function cotizacion()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_detalle', 'productoFk', 'cotizacionFk')->withTimestamps();
    }
    public function scopeCantidadMaximaPerecedero($query,$id,$cantidad,$idPerecedero = null)
    {
        $producto = $query->where('id',$id);
        if(empty($producto->first())){
            return ['error' => 'no se encontro el producto'];
        }
        $producto = $producto->with("presentacion")->withSum(["perecederos" => function($sub) use($idPerecedero){
            $sub->where('estado',1);
            if(!empty($idPerecedero)){
                $sub->where('id','!=',$idPerecedero);
            }
        }],"cantidad")->first();
        $cantidadMax = intval($producto->perecederos_sum_cantidad) + intval($cantidad);
        $cantidadPermitida = $producto->cantidad - intval($producto->perecederos_sum_cantidad);
        if($cantidadPermitida <= 0){
            return ["error" => "Se superó el limite de cantidad permitida, si desea agregar más perecederos, intente ampliar el stock del producto"];
        }
        if($cantidadMax > $producto->cantidad){
            return ['error' => 'La cantidad máxima para el producto ' . $producto->nombreProducto . ' es de ' . $cantidadPermitida. ' '. $producto->presentacion->siglas .', por favor intente ingresando la cantidad máxima o inferior.'];
        }
        return ['success' => true];
    }
}
