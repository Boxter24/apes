<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Foros extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_foro', 'comentario_foro' , 'id_usuario',
    ];
}
