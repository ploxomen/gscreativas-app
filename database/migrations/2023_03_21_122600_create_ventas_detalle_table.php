<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("ventaFk");
            $table->unsignedBigInteger("productoFk");
            $table->decimal("costo",11);
            $table->integer("cantidad");
            $table->decimal("importe",11);
            $table->decimal("igv",11);
            $table->decimal("descuento",11);
            $table->decimal("total",11);
            $table->foreign("ventaFk")->references("id")->on("ventas");
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
        Schema::dropIfExists('ventas_detalle');
    }
}
