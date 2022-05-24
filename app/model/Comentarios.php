<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{   
    public $timestamps = false;
    
    protected $fillable = [
        'id_foro', 'comentario', 'id_usuario', 'fecha_comentario', 'estado'
    ];
}
