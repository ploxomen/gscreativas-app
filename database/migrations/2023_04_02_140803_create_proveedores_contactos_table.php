<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores_contactos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("proveedoresFk");
            $table->unsignedBigInteger("tipo_documento")->nullable();
            $table->string("nro_documento")->nullable();
            $table->string("cargo")->nullable();
            $table->string("nombres_completos");
            $table->string("correo")->nullable();
            $table->string("celular")->nullable();
            $table->string("telefono")->nullable();
            $table->integer("estado")->default(1);
            $table->dateTimeTz("fechaCreada");
            $table->dateTimeTz("fechaActualizada");
            $table->foreign("tipoDocumento")->references("id")->on("tipo_documento");
            $table->foreign("proveedoresFk")->references("id")->on("proveedores");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores_contactos');
    }
}
