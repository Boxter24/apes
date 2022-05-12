<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Detalles extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_institucion', 'descripcion_institucion' , 'direccion_institucion', 'telefono_institucion', 'correo_institucion', 'servicios_institucion', 'logo_institucion',
    ];
}
