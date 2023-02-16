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
            $table->string("nombres");
            $table->string("apellidos");
            $table->string("contrasena");
            $table->string("telefono");
            $table->string("celular");
            $table->string("direccion");
            $table->date("fechaCumple");
            $table->string("recordarToken");
            $table->char("sexo",1);
            $table->integer("estado");
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
