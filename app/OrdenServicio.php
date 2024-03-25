<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    public $table = "orden_servicio";
    protected $fillable = ['fk_cliente','fk_producto','fk_sucursal','fk_auto','fk_cita','total','estadoSaldo','estado','estatus'];
    public function orden()
    {
        return $this->hasMany('App\OrdenSubservicio');
    }
    public function ordenP()
    {
        return $this->hasMany('App\OrdenProductos');
    }
}
