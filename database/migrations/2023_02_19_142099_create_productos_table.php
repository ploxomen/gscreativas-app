<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("codigoBarra")->unique();
            $table->string("nombreProducto");
            $table->string("descripcion")->nullable();
            $table->decimal('cantidad');
            $table->decimal('precioVenta');
            $table->decimal('precioVentaPorMayor');
            $table->decimal('precioCompra');
            $table->unsignedBigInteger('categoriaFk');
            $table->unsignedBigInteger('marcaFk');
            $table->unsignedBigInteger('presentacionFk');
            $table->foreign("categoriaFk")->references("id")->on("categoria");
            $table->foreign("marcaFk")->references("id")->on("marca");
            $table->foreign("presentacionFk")->references("id")->on("presentacion");
            $table->string("urlImagen");
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
        Schema::dropIfExists('productos');
    }
}
