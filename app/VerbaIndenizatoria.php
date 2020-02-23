<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerbaIndenizatoria extends Model
{
    protected $fillable = [
        'nome', 'mes', 'idDeputado'
    ];
}
