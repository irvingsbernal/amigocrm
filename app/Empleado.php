<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = 
    ['noEmpleado','nss','fk_user','fk_puesto','estatus'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function puesto(){
        return $this->belongsTo('App\Puesto');
    }
    
}
