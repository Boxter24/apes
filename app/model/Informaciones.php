<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Informaciones extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_informacion', 'descripcion_informacion' , 'enlace_informacion', 'prioridad_informacion', 'foto',
    ];
}
