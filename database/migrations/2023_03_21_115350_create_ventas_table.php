<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date("fechaVenta");
            $table->unsignedBigInteger("tipoComprobanteFk");
            $table->string("serieComprobante");
            $table->string("numeroComprobante");
            $table->unsignedBigInteger("clienteFk");
            $table->string("metodoPago");
            $table->string("cuentaBancaria")->nullable();
            $table->string("billeteraDigital")->nullable();
            $table->string("numeroOperacion")->nullable();
            $table->string("metodoEnvio");
            $table->integer("aCredito")->default(0)->nullable();
            $table->integer("criditoPagado")->default(0)->nullable();
            $table->decimal("subTotal",11)->nullable();
            $table->decimal("igvTotal",11)->nullable();
            $table->decimal("descuentoTotal",11)->nullable();
            $table->decimal("envio",11);
            $table->decimal("total",11)->nullable();
            $table->decimal("montoPagado",11);
            $table->decimal("vuelto",11)->default(0)->nullable();
            $table->integer("estado")->default(1);
            $table->dateTimeTz("fechaCreada");
            $table->dateTimeTz("fechaActualizada");
            $table->foreign("tipoComprobanteFk")->references("id")->on("comprobantes");
            $table->foreign("clienteFk")->references("id")->on("clientes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
