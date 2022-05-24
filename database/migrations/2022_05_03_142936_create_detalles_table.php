<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_institucion');
            $table->string('descripcion_institucion')->nullable();
            $table->string('direccion_institucion');
            $table->string('telefono_institucion');
            $table->string('correo_institucion')->unique();
            $table->string('servicios_institucion')->nullable();
            $table->string('logo_institucion')->nullable()->default('logo_institucion.png'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles');
    }
}
