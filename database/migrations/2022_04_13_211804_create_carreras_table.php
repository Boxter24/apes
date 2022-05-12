<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_carrera');
            $table->string('descripcion_carrera')->nullable();
            $table->string('foto')->default('carrera.png');    
            $table->unsignedInteger('id_facultad');

            $table->foreign('id_facultad')
                  ->references('id')->on('facultades')
                  ->nullable()                  
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carreras');
    }
}
