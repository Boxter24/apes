<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_seccion');
            $table->string('descripcion_seccion');            
            $table->unsignedInteger('id_carrera');
            $table->unsignedInteger('id_categoria');
            $table->string('enlace_seccion')->default('null');            
            $table->string('foto')->default('seccion.png');                        

            $table->foreign('id_carrera')
                  ->references('id')->on('carreras')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');                            

            $table->foreign('id_categoria')
                    ->references('id')->on('categorias')                 
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
        Schema::dropIfExists('secciones');
    }
}
