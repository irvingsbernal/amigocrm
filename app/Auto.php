<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    public $table = "autos";
    protected $fillable =[
        'marca','modelo','anio','numerovinserie','color','placa','kilometraje','fotografia','estatus','fk_cliente'
    ];
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }
}
