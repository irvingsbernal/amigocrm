<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    public $table = "inventarios";
    protected $fillable = ['fk_producto','cantidad','estatus'];
    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }
}