<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $table = "clientes";
    protected $fillable = ['numerocliente', 'codigoactivacion', 'estatus', 'fk_usuer'];
    
    public function usuario() {
        return $this->belongsTo('App\Users');
    }
    public function automovil()
    {
        return $this->hasMany('App\Auto');
    }
}
