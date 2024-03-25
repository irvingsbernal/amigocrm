<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//IMPORTANTISIMO: MIra we cuando crees un modelo recerda que el nombre del modelo debe ser
//singular de la tabla por ejemplo DB:categorias; Model:categoria
//Cuidado con los singulares irregulares por ejmeplo DB:Sucursales; modal: Sucursale
//por que esta madre agrega una "s" cuando hace el request.
class Sucursale extends Model
{
    protected $fillable = ['nombreComercial', 'razonSocial', 'direccion', 'codigoUbicacion', 'numEmpleados', 'cupoAutos', 'stockCupo', 'longitud', 'latitud', 'horaInicio', 'horaFin', 'estatus'];
}