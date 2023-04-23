<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion', function (Blueprint $table) {
            $table->id();
            $table->dateTimeTz("fechaCotizacion");
            $table->string("cliente")->nullable();
            $table->string("metodoEnvio");
            $table->string("tipoPago")->nullable();
            $table->decimal("importe")->nullable();
            $table->decimal("igv")->nullable();
            $table->decimal("descuento")->nullable();
            $table->decimal("envio")->nullable();
            $table->decimal("total")->nullable();
            $table->unsignedBigInteger("cotizadorUsuario");
            $table->integer("estado")->default(1);
            $table->dateTimeTz("fechaCreada");
            $table->dateTimeTz("fechaActualizada");
            $table->foreign("cotizadorUsuario")->references("id")->on("usuarios");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion');
    }
}
