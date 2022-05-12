<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Carreras extends Model
{   
    public $timestamps = false;

    protected $fillable = [
        'nombre_carrera', 'descripcion_carrera','foto','id_facultad' ,
    ];
}
