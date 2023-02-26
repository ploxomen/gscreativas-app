<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("moduloFk");
            $table->unsignedBigInteger("rolFk");
            $table->foreign("moduloFk")->references("id")->on("modulo");
            $table->foreign("rolFk")->references("id")->on("rol");
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
        Schema::dropIfExists('modulo_roles');
    }
}
