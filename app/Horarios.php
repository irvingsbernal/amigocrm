<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $fillable = ['fk_sucursal','horaInicio', 'horaFin'];
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursale');
    }
}
