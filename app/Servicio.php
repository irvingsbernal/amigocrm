<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = ['nombre','estatus'];
    public function subServicios()
    {
        return $this->hasMany('App\SubServicio'); //Cambiar
    }
}
