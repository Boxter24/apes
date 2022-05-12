<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_categoria', 'descripcion_categoria', 'foto',
    ];    
}
