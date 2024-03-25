<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;

class ServicioController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $servicio = Servicio::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $servicio = Servicio::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        

 

        return [
            'pagination' => [
                'total'        => $servicio->total(),
                'current_page' => $servicio->currentPage(),
                'per_page'     => $servicio->perPage(),
                'last_page'    => $servicio->lastPage(),
                'from'         => $servicio->firstItem(),
                'to'           => $servicio->lastItem(),
            ],
            'servicio' => $servicio
        ];
    }


    public function selectServicio(Request $request){
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::where('estatus','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['servicio' => $servicio];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = new Servicio();
        $servicio->nombre = $request->nombre;
        $servicio->estatus = '1';
        $servicio->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->nombre = $request->nombre;
        $servicio->estatus = '1';
        $servicio->save();
    }

 

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->estatus = '0';
        $servicio->save();
    }

 

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->estatus = '1';
        $servicio->save();
    }
    
}
