<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table = 'detalleIngresos';
    protected $fillable = [
        'fk_ingreso', 
        'fk_producto',
        'cantidad',
        'precio'
    ];
    public $timestamps = false;

}

