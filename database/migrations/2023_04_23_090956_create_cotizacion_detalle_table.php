<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cotizacionFk");
            $table->unsignedBigInteger("productoFk");
            $table->decimal("costo");
            $table->integer("cantidad");
            $table->decimal("importe");
            $table->decimal("igv");
            $table->decimal("descuento");
            $table->decimal("total");
            $table->dateTimeTz("fechaCreada");
            $table->dateTimeTz("fechaActualizada");
            $table->foreign("cotizacionFk")->references("id")->on("cotizacion");
            $table->foreign("productoFk")->references("id")->on("productos");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion_detalle');
    }
}
