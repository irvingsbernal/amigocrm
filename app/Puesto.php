<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $fillable = ['nombre','descripcion','estatus'];

    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }
}
