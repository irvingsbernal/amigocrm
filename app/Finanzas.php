<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finanzas extends Model
{
    protected $fillable = [
        'registro', 
        'tipo',
        'fecha',
        'concepto',
        'monto',
        'documento',
        'noDocumento',
        'serieDocumento',
        'estatus'
    ];
}
