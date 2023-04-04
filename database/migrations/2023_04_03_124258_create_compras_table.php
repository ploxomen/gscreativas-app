<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("proveedorFk");
            $table->unsignedBigInteger("comprobanteFk");
            $table->string("nroComprobante");
            $table->date("fechaComprobante");
            $table->string("tipoCompra");
            $table->integer("estado");
            $table->dateTimeTz("fechaCreada");
            $table->dateTimeTz("fechaActualizada");
            $table->foreign("proveedorFk")->references("id")->on("proveedores");
            $table->foreign("comprobanteFk")->references("id")->on("comprobantes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
