<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerecederosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perecederos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productoFk');
            $table->foreign("productoFk")->references("id")->on("productos");
            $table->integer('cantidad');
            $table->date("vencimiento");
            $table->integer("estado")->default(1);
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
        Schema::dropIfExists('perecederos');
    }
}
