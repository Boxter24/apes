<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_foro');
            $table->longText('comentario');
            $table->unsignedInteger('id_usuario');
            $table->string('fecha_comentario')->nullable();
            $table->string('estado')->default('inactivo');

            $table->foreign('id_foro')
                  ->references('id')->on('foros')
                  ->nullable()                  
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_usuario')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('comentarios');
    }
}
