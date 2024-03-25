<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubServicio;
use App\Servicio;
use App\Producto;

class CotizacionController extends Controller
{
    public function index(Request $request)
    {
    }
    
    public function selectSubServicioCoti(Request $request){
        if (!$request->ajax()) return redirect('/');
        $subServicio = SubServicio::where('estatus','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['subServicios' => $subServicio];
    }

    public function selectProductoCoti(Request $request){
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::where('estatus','=','1')
        ->select('id','nombre', 'presentacionInterfaz', 'unidad')->orderBy('nombre', 'asc')->get();
        return ['productos' => $producto];
    }

    public function anadirServicioCoti(Request $request){
        if (!$request->ajax()) return redirect('/');
        $subServicio = SubServicio::findOrFail($request->id);
        return ['subServicios' => $subServicio];
    }
    
    public function anadirProductoCoti(Request $request){
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        return ['productos' => $producto];
    }
}
