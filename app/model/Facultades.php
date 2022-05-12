<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Facultades extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_facultad', 'descripcion_facultad' , 'foto',
    ];
}
