<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Secciones extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_seccion', 'descripcion_seccion','id_carrera','id_categoria', 'enlace_seccion','foto'
    ];
}
