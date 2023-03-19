<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string("nombreCliente");
            $table->unsignedBigInteger("tipoDocumento")->nullable();
            $table->string("nroDocumento")->nullable();
            $table->string("telefono")->nullable();
            $table->string("celular")->nullable();
            $table->string("correo")->nullable();
            $table->string("direccion")->nullable();
            $table->decimal("limteCredito",11,2)->nullable();
            $table->foreign("tipoDocumento")->references("id")->on("tipo_documento");
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
        Schema::dropIfExists('clientes');
    }
}
