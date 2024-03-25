<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = 
    ['FkidCategoria','nombre','marca','modelo', 'presentacionInterfaz', 'presentacion', 'unidad','codigoBarras','descripcion','precioCompra','precioVenta', 'imagen', 'productos.ventaXpartes','estatus'];

    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
