<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeSocial extends Model
{
    protected $fillable = [
        'nome', 'url', 'deputados_id'
    ];
}
