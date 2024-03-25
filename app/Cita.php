<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    public $table = "cita";
    protected $fillable = ['comentario','fecha','hora','estatus','fk_horario','fk_auto','fk_usuario','fk_sucursal'];

    // public function horario()
    // {
    //     return $this->belongsTo('App\HorarioCita');
    // }
    public function auto()
    {
        return $this->belongsTo('App\Auto');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursale');
    }

    public function horario()
    {
        return $this->belongsTo('App\Horarios');
    }
}
