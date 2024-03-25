<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenProductos extends Model
{
    protected $fillable = ['fk_orden','fk_producto', 'cantidad', 'precioProducto'];
    public function ordenPadre()
    {
        return $this->belongsTo('App\OrdenServicio');
    }
}
