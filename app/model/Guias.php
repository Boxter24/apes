<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Guias extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre_guia',
    ];
}
