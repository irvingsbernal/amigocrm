<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subservicio extends Model
{
    protected $fillable = ['fk_servicio','nombre','costoServicio','estatus'];
    public function servicio()
    {
        return $this->belongsTo('App\Servicio');
    }
}
