<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "proveedores";
    protected $fillable = 
    ['nombreComercial','razonSocial','rfc','telefono','correo','direccion','estatus'];

    // public function proveedor(){
    //     return $this->belongsTo('App\Proveedor');
    // }
}
