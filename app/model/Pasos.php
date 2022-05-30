<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Pasos extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_paso', 'orden_paso', 'descripcion_paso','enlace_paso','foto', 'id_guia',
    ];
}
