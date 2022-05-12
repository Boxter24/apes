<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_informacion');
            $table->string('descripcion_informacion')->nullable();
            $table->string('enlace_informacion')->nullable();
            $table->string('prioridad_informacion')->nullable();
            $table->string('foto')->nullable()->default('informacion.png');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informaciones');
    }
}
