<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Sucursale;
use App\Horarios;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $sucursales = Sucursale::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $sucursales = Sucursale::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $sucursales->total(),
                'current_page' => $sucursales->currentPage(),
                'per_page'     => $sucursales->perPage(),
                'last_page'    => $sucursales->lastPage(),
                'from'         => $sucursales->firstItem(),
                'to'           => $sucursales->lastItem(),
            ],
            'sucursales' => $sucursales
        ];
    }

    public function selectSucursal(Request $request){
        if (!$request->ajax()) return redirect('/');

        $sucursales = Sucursale::where('estatus','=','1')
        ->select('id','nombreComercial')->orderBy('nombreComercial', 'asc')->get();

        return ['sucursales' => $sucursales];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $sucursal = new Sucursale();
            $sucursal->nombreComercial = $request->nombreComercial;
            $sucursal->razonSocial = $request->razonSocial;
            $sucursal->direccion = $request->direccion;
            $sucursal->codigoUbicacion = $request->codigoUbicacion;
            $sucursal->numEmpleados = $request->numEmpleados;
            $sucursal->cupoAutos = $request->cupoAutos;
            $sucursal->stockCupo = $request->cupoAutos;
            $sucursal->longitud = $request->longitud;
            $sucursal->latitud = $request->latitud;
            $sucursal->horaInicio = '09:00:00';
            $sucursal->horaFin = '18:00:00';
            $sucursal->estatus = '1';
            $sucursal->save();

            $inicio=substr($sucursal->horaInicio,0,2);
            $fin = substr($sucursal->horaFin,0,2);

            for($i=$inicio; $i <= $fin;$i++){
                $inicio++;
                $horario = new Horarios();
                $horario->horaInicio = $i.":00:00";
                $horario->horaFin = $inicio.":00:00";
                $horario->fk_sucursal = $sucursal->id;
                $horario->save();
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursale::findOrFail($request->id);
        $sucursal->nombreComercial = $request->nombreComercial;
        $sucursal->razonSocial = $request->razonSocial;
        $sucursal->direccion = $request->direccion;
        $sucursal->codigoUbicacion = $request->codigoUbicacion;
        $sucursal->numEmpleados = $request->numEmpleados;
        $sucursal->cupoAutos = $request->cupoAutos;
        $sucursal->stockCupo = $request->stockCupo;
        $sucursal->longitud = $request->longitud;
        $sucursal->latitud = $request->latitud;
        $sucursal->estatus = '1';
        $sucursal->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursale::findOrFail($request->id);
        $sucursal->estatus = '0';
        $sucursal->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursale::findOrFail($request->id);
        $sucursal->estatus = '1';
        $sucursal->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function configurarHorario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursale::findOrFail($request->id);
        $sucursal->horaInicio = $request->horaInicio;
        $sucursal->horaFin = $request->horaFin;
        $sucursal->save();
    }
    
	public function selectSucursalOrden(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $sucursales = DB::select('select * from sucursales WHERE stockCupo > 0 and stockCupo <= cupoAutos and estatus=1;');
        return ['sucursales' => $sucursales];
    }
}


