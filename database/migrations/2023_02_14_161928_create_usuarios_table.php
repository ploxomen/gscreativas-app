<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string("correo");
            $table->string("tipoDocumento")->nullable();
            $table->string("nroDocumento")->nullable();
            $table->string("nombres");
            $table->string("apellidos");
            $table->string("contrasena");
            $table->string("telefono")->nullable();
            $table->string("celular")->nullable();
            $table->string("direccion")->nullable();
            $table->date("fechaCumple")->nullable();
            $table->string("recordarToken")->nullable();
            $table->char("sexo",1)->nullable();
            $table->integer("estado")->default(2);
            $table->unsignedBigInteger("areaFk");
            $table->foreign("areaFk")->references("id")->on("area");
            $table->dateTimeTz("fechaCreada");
            $table->dateTimeTz("fechaActualizada");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
