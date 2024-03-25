<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Puesto;

class PuestoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $puestos = Puesto::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $puestos = Puesto::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $puestos->total(),
                'current_page' => $puestos->currentPage(),
                'per_page'     => $puestos->perPage(),
                'last_page'    => $puestos->lastPage(),
                'from'         => $puestos->firstItem(),
                'to'           => $puestos->lastItem(),
            ],
            'puestos' => $puestos
        ];
    }

    public function seleccionarPuesto(Request $request){
        if (!$request->ajax()) return redirect('/');
        $puestos = Puesto::where('estatus','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['puestos' => $puestos];
    }

    public function guardar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Puesto = new Puesto();
        $Puesto->nombre = $request->nombre;
        $Puesto->descripcion = $request->descripcion;
        $Puesto->estatus = '1';
        $Puesto->save();
    }
    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Puesto = Puesto::findOrFail($request->id);
        $Puesto->nombre = $request->nombre;
        $Puesto->descripcion = $request->descripcion;
        $Puesto->estatus = '1';
        $Puesto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Puesto = Puesto::findOrFail($request->id);
        $Puesto->estatus = '0';
        $Puesto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Puesto = Puesto::findOrFail($request->id);
        $Puesto->estatus = '1';
        $Puesto->save();
    }
}
