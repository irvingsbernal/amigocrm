<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubServicio;

class SubServicioController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $subservicios = subservicio::join('servicios','subservicios.fk_servicio','=','servicios.id')
            ->select('subservicios.id', 'subservicios.fk_servicio','servicios.nombre as nombre_servicio','subservicios.nombre', 
                     'subservicios.costoServicio','subservicios.estatus')
            ->orderBy('subservicios.id', 'desc')->paginate(10);
        }
        else{
            $subservicios = subservicio::join('servicios','subservicios.fk_servicio','=','servicios.id')
            ->select('subservicios.id', 'subservicios.fk_servicio','servicios.nombre as nombre_servicio','subservicios.nombre', 
            'subservicios.costoServicio','subservicios.estatus')
            ->where('subservicios.'.$criterio, 'like', '%'. $buscar. '%')
            ->orderBy('subservicios.id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'        => $subservicios->total(),
                'current_page' => $subservicios->currentPage(),
                'per_page'     => $subservicios->perPage(),
                'last_page'    => $subservicios->lastPage(),
                'from'         => $subservicios->firstItem(),
                'to'           => $subservicios->lastItem(),
            ],
            'subservicios' => $subservicios
        ];
    }
    
    public function listarSubServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $subservicio = subservicio::join('servicios','subservicios.fk_servicio','=','servicios.id')
            ->select('subservicios.id', 'subservicios.fk_servicio','servicios.nombre as nombre_servicio','subservicios.nombre',
            'subservicios.costoServicio','subservicios.estatus')
            ->orderBy('subservicios.id', 'desc')->paginate(100);
        }
        else{
            $subservicio = subservicio::join('servicios','subservicios.fk_servicio','=','servicios.id')
            ->select('subservicios.id', 'subservicios.fk_servicio','servicios.nombre as nombre_servicio','subservicios.nombre',
            'subservicios.costoServicio','subservicios.estatus')
            ->where('subservicios.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('subservicios.id', 'desc')->paginate(100);
        }
        

        return ['subservicios' => $subservicio];
    }
    
    public function listarServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $subservicio = subservicio::join('servicios','subservicios.fk_servicio','=','servicios.id')
            ->select('subservicios.id', 'subservicios.fk_servicio','servicios.nombre as nombre_servicio','subservicios.nombre',
            'subservicios.costoServicio','subservicios.estatus')
            ->where('subservicio.estatus','>','0')
            ->orderBy('subservicios.id', 'desc')->paginate(10);

            
        }
        else{
            $subservicio = subservicio::join('servicios','subservicios.fk_servicio','=','servicios.id')
            ->select('subservicios.id', 'subservicios.fk_servicio','servicios.nombre as nombre_servicio',
            'subservicios.nombre','subservicios.costoServicio','subservicios.estatus')
            ->where('subservicio.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('subservicio.estatus','>','0')
            ->orderBy('subservicio.id', 'desc')->paginate(10);
        }
        

        return ['subservicio' => $subservicio];
    }


    

    public function buscarSubServicioOrden(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->id;
        $subservicio = subservicio::where('fk_servicio','=', $filtro)
        ->select('id','nombre','costoServicio')
        ->orderBy('nombre', 'asc')
        ->get();
        return ['subservicio' => $subservicio];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $subservicio = new Subservicio();
        $subservicio->fk_servicio = $request->fk_servicio;
        $subservicio->nombre = $request->nombre;
        $subservicio->costoServicio = $request->costoServicio;
        $subservicio->estatus = '1';
        $subservicio->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $subservicio = subservicio::findOrFail($request->id);
        $subservicio->fk_servicio = $request->fk_servicio;
        $subservicio->nombre = $request->nombre;
        $subservicio->costoServicio = $request->costoServicio;
        $subservicio->estatus = '1';
        $subservicio->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $subservicio = Subservicio::findOrFail($request->id);
        $subservicio->estatus = '0';
        $subservicio->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $subservicio = subservicio::findOrFail($request->id);
        $subservicio->estatus = '1';
        $subservicio->save();
    }
}
