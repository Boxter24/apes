<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_paso');
            $table->string('descripcion_paso');
            $table->integer('orden_paso');
            $table->string('enlace_paso')->nullable();
            $table->string('foto')->default('paso.png');    
            $table->unsignedInteger('id_guia');

            $table->foreign('id_guia')
                  ->references('id')->on('guias')
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
        Schema::dropIfExists('pasos');
    }
}
