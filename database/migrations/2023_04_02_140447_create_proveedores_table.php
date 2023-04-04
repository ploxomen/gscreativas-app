<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("tipo_documento");
            $table->string("nro_documento");
            $table->string("nombre_proveedor");
            $table->string("telefono")->nullable();
            $table->string("celular")->nullable();
            $table->string("correo")->nullable();
            $table->string("direccion")->nullable();
            $table->integer("estado")->default(1);
            $table->dateTimeTz("fechaCreada");
            $table->dateTimeTz("fechaActualizada");
            $table->foreign("tipoDocumento")->references("id")->on("tipo_documento");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
