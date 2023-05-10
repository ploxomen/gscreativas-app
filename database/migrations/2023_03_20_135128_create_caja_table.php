<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("usuarioFk");
            $table->date("fecha_caja");
            $table->dateTimeTz("fecha_hr_inicio");
            $table->dateTimeTz("fecha_hr_termino")->nullable();
            $table->decimal("importe_total")->nullable()->default(0);
            $table->decimal("igv_total")->nullable()->default(0);
            $table->decimal("envio_total")->nullable()->default(0);
            $table->decimal("descuento_total")->nullable()->default(0);
            $table->decimal("total")->nullable()->default(0);
            $table->foreign("usuarioFk")->references("id")->on("usuarios");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja');
    }
}
