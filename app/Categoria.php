<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //protected $table = 'categorias'
    //protected $primaryKey = 'id'; --Obsoletos
    protected $fillable = ['nombre','descripcion','estatus'];

    public function productos()
    {
        return $this->hasMany('App\Producto');
    }
}
