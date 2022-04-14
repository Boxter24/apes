<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $fillable = [
        'nombre_categoria', 'descripcion_categoria' ,
    ];
    public function getKeyName(){
        return "id_categoria";
    }
}
