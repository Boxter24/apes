<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Colores extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'color', 'uso' , 
    ];
}
