<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController2 extends Controller
{
    public function __invoke(Request $request){

       //Formateamos año:
        $anio=date('Y');
        
        //Realizamos consulta ingreso de mercancía:
        $ingresos=DB::table('ingresos as i')
        ->select(DB::raw('MONTH(i.fechaHora) as mes'),
        DB::raw('YEAR(i.fechaHora) as anio'),
        DB::raw('SUM(i.total) as total'))
        ->whereYear('i.fechaHora',$anio)
        ->groupBy(DB::raw('MONTH(i.fechaHora)'),DB::raw('YEAR(i.fechaHora)'))
        ->get();

        //Realizamos consulta retorno de mercancía:
        $retornos=DB::table('ingresos as i')
        ->select(DB::raw('MONTH(i.fechaHora) as mes'),
        DB::raw('YEAR(i.fechaHora) as anio'),
        DB::raw('SUM(i.total) as total'))
        ->where('estatus','=','Cancelado')
        ->whereYear('i.fechaHora',$anio)
        ->groupBy(DB::raw('MONTH(i.fechaHora)'),DB::raw('YEAR(i.fechaHora)'))
        ->get();

        //Realizamos consulta retorno de mercancía:
        $sucursales = DB::table('sucursales as su')
                      ->select(DB::raw('su.id'),
                               DB::raw('su.nombreComercial'),
                               DB::raw('su.latitud'),
                               DB::raw('su.longitud'))->where('estatus', '=', 1)
                                                      ->where('cupoAutos', '>', 1)
                      ->groupBy(DB::raw('su.id'),DB::raw('su.nombreComercial'), 
                                DB::raw('su.latitud'), DB::raw('su.longitud'))->get();


        

        //RETORNA DATA QUERYS:
        return [
                'ingresos'   => $ingresos, 
                'retornos'   => $retornos, 
                'sucursales' => $sucursales,
                'anio'       => $anio
               ];  
    }
}
