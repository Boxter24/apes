<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Carrusel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'foto',
    ];
}
