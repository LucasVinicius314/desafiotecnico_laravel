<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    protected $fillable = [
        'id', 'nome', 'nomeServidor', 'partido', 'email'
    ];
}
