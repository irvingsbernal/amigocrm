<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenSubservicio extends Model
{
    public $table = "orden_subservicio";
    protected $fillable = ['fk_orden','fk_subservicio','precioServicio','estatus'];
    public function ordenPadre()
    {
        return $this->belongsTo('App\OrdenServicio');
    }
}
