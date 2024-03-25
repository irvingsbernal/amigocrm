<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
        'fk_proveedor', 
        'fk_user',
        'documento',
        'serieDocumneto',
        'noDocumento',
        'fechaHora',
        'impuesto',
        'total',
        'estatus'
     ];
     public function user()
     {
         return $this->belongsTo('App\User');
     }
     public function proveedor()
     {
         return $this->belongsTo('App\Proveedor');
     }
 
 
}