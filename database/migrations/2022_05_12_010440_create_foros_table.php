<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_foro');
            $table->longText('comentario_foro');
            $table->unsignedInteger('id_usuario');
            $table->timestamp('fecha_publicacion')->nullable();
            $table->string('estado')->default('inactivo');

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
        Schema::dropIfExists('foros');
    }
}
