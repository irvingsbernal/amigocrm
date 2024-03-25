<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre','apellidoPaterno','apellidoMaterno','rfc','direccion','telefono','foto','correo', 'password', 'rol', 'estatus'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function empleado(){
        return $this->belongsTo('App\Empleado');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }

}
