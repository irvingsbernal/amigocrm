<?php

namespace App\Http\Controllers;

use App\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $autos = Auto::join('clientes','autos.fk_cliente','=','clientes.id')
            ->select('autos.id','autos.fk_cliente','autos.marca','autos.modelo','autos.anio',
            'autos.numerovinserie','autos.color','autos.placa','autos.kilometraje','autos.fotografia','autos.estatus')
            ->orderBy('autos.id', 'desc')->paginate(10);
        }
        else{
            $autos = Auto::join('clientes','autos.fk_cliente','=','clientes.id')
            ->select('autos.id','autos.fk_cliente','autos.marca','autos.modelo','autos.anio',
            'autos.numerovinserie','autos.color','autos.placa','autos.kilometraje','autos.fotografia','autos.estatus')
            ->where('autos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('autos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $autos->total(),
                'current_page' => $autos->currentPage(),
                'per_page'     => $autos->perPage(),
                'last_page'    => $autos->lastPage(),
                'from'         => $autos->firstItem(),
                'to'           => $autos->lastItem(),
            ],
            'autos' => $autos
        ];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = new Auto();
        $articulo->marca = $request->marca;
        $articulo->modelo = $request->modelo;
        $articulo->anio = $request->anio;
        $articulo->numerovinserie = strtoupper($request->numerovinserie);
        $articulo->color = $request->color;
        $articulo->placa = strtoupper($request->placa);
        $articulo->kilometraje = $request->kilometraje;
        $articulo->estatus = 1;
        $articulo->fotografia = $request->fotografia;
        $articulo->fk_cliente = $request->fk_cliente;
        $articulo->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Auto::findOrFail($request->id);
        $articulo->marca = $request->marca;
        $articulo->modelo = $request->modelo;
        $articulo->anio = $request->anio;
        $articulo->numerovinserie = strtoupper($request->numerovinserie);
        $articulo->color = $request->color;
        $articulo->placa = strtoupper($request->placa);
        $articulo->kilometraje = $request->kilometraje;
        $articulo->fotografia = $request->fotografia;
        // $articulo->fk_cliente = $request->fk_cliente;
        $articulo->fk_cliente = $request->fk_cliente;
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Auto::findOrFail($request->id);
        $articulo->estatus = 0;
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Auto::findOrFail($request->id);
        $articulo->estatus = 1;
        $articulo->save();
    }

    public function selectAutoOrden(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $auto = Auto::where('estatus','=','1')
        ->where('fk_cliente','=',$filtro)
        ->select('id',(DB::raw("CONCAT(marca,'-',modelo,'-',anio) AS nombre")))
        //->where(DB::raw("CONCAT(personas.nombre,'',personas.apellidoPaterno,' ',personas.apellidoMaterno)"), 'LIKE', "%".$filtro."%")
        //'marca','modelo','anio')
        ->orderBy('id', 'asc')->get();
        return ['autos' => $auto];
    }
}