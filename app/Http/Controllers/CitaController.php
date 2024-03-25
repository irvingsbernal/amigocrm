<?php

namespace App\Http\Controllers;

use App\Cita;
use App\OrdenServicio;
use App\Sucursale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CitaController extends Controller
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
        $usuario = $request->usuario;
        
        if ($buscar==''){
            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('horarios','cita.fk_horario', '=', 'horarios.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin',
                     'cita.estatus','sucursales.nombreComercial',
                     'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
            ->where('cita.fk_usuario', '=', $usuario)
            ->orderBy('cita.id', 'desc')->paginate(10);
        }
        else{
            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('horarios','cita.fk_horario', '=', 'horarios.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin',
                     'cita.estatus','sucursales.nombreComercial',
                     'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
            ->where('cita.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('cita.fk_usuario', '=', $usuario)
            ->orderBy('cita.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $citas->total(),
                'current_page' => $citas->currentPage(),
                'per_page'     => $citas->perPage(),
                'last_page'    => $citas->lastPage(),
                'from'         => $citas->firstItem(),
                'to'           => $citas->lastItem(),
            ],
            'citas' => $citas
        ];
        // if ($buscar==''){
        //     $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
        //     ->join('autos','cita.fk_auto','=','autos.id')
        //     ->join('horarios','cita.fk_horario', '=', 'horarios.id')
        //     ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
        //              'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin',
        //              'cita.estatus','sucursales.nombreComercial',
        //              'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
        //     // ->where('fecha', '>=', 'date_format(current_date(),"%y-%m-%d")')
        //     ->where('cita.estatus', '=' , 1)
        //     ->where('cita.fk_usuario', '=', $usuario)
        //     ->orderBy('cita.fecha', 'desc')->paginate(5);
        // }
        // else{
        //     $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
        //     ->join('autos','cita.fk_auto','=','autos.id')
        //     ->join('horarios','cita.fk_horario', '=', 'horarios.id')
        //     ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
        //              'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin',
        //              'cita.estatus','sucursales.nombreComercial',
        //              'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
        //     ->where('fecha', '>=', 'date_format(current_date(),"%y-%m-%d")')
        //     ->where('cita.estatus', '=' , 1)
        //     ->where('cita.'.$criterio, 'like', '%'. $buscar . '%')
        //     ->where('cita.fk_usuario', '=', $usuario)
        //     ->orderBy('cita.fecha', 'desc')->paginate(5);
            
        // }
    }

    public function obtenerCitasDashboard(Request $request){
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
    
        $usuario = $request->usuario;
        $idCita = $request->idcita;
        
        if ($buscar==''){
            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('horarios','cita.fk_horario', '=', 'horarios.id')
            ->join('users', 'cita.fk_usuario', '=','users.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario', 'cita.estatus',
                     'horarios.horaInicio','horarios.horaFin',
                     'sucursales.nombreComercial', 'sucursales.direccion',
                     'autos.marca','autos.modelo','autos.placa',
                     'users.nombre', 'users.apellidoPaterno','users.correo', 'users.telefono')
            ->where('fecha', '>=', DB::raw('date_format(current_date(),"%y-%m-%d")'))
            ->where('cita.estatus', '=' , 1)   
            ->orderBy('cita.fecha', 'desc')->paginate(5); 

        }
        else if($criterio == 'id'){

            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('horarios','cita.fk_horario', '=', 'horarios.id')
            ->join('users', 'cita.fk_usuario', '=','users.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario', 'cita.estatus',
                     'horarios.horaInicio','horarios.horaFin',
                     'sucursales.nombreComercial', 'sucursales.direccion',
                     'autos.marca','autos.modelo','autos.placa',
                     'users.nombre', 'users.apellidoPaterno','users.correo', 'users.telefono')
            ->where('fecha', '>=', DB::raw('date_format(current_date(),"%y-%m-%d")'))
            ->where('cita.estatus', '=' , 1) 
            ->where('cita.id', 'like', '%'. $buscar . '%')  
            ->orderBy('cita.fecha', 'desc')->paginate(5);

        }else if($criterio == 'numerocliente'){

            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('horarios','cita.fk_horario', '=', 'horarios.id')
            ->join('users', 'cita.fk_usuario', '=','users.id')
            ->join('clientes', 'clientes.fk_user', '=' ,'clientes.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario', 'cita.estatus',
                     'horarios.horaInicio','horarios.horaFin',
                     'sucursales.nombreComercial', 'sucursales.direccion',
                     'autos.marca','autos.modelo','autos.placa',
                     'users.nombre', 'users.apellidoPaterno','users.correo', 'users.telefono',
                     'clientes.numerocliente')
            ->where('fecha', '>=', DB::raw('date_format(current_date(),"%y-%m-%d")'))
            ->where('cita.estatus', '=' , 1) 
            ->where('clientes.numerocliente', 'like', '%'. $buscar . '%')  
            ->orderBy('cita.fecha', 'desc')->paginate(5);

        }
        return [
            'pagination' => [
                'total'        => $citas->total(),
                'current_page' => $citas->currentPage(),
                'per_page'     => $citas->perPage(),
                'last_page'    => $citas->lastPage(),
                'from'         => $citas->firstItem(),
                'to'           => $citas->lastItem(),
            ],  
            'citas' => $citas
        ];
        
        return ['citas' => $citas];
    }

    public function obtenerCliente(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::select('clientes.id','clientes.numerocliente','clientes.codigoactivacion')
        ->where('clientes.fk_user','=',$request->idUsuario)
        ->orderBy('clientes.id', 'desc')->paginate(3);
        return [
            'cliente' => $cliente
        ];
    }


    public function obtenerCitasRecientes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $usuario = $request->usuario;

        // $latestPosts = DB::table('posts')
        //            ->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
        //            ->where('is_published', true)
        //            ->groupBy('user_id');

        $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
                       ->join('autos','cita.fk_auto','=','autos.id')
                       ->join('horarios','cita.fk_horario', '=', 'horarios.id')
                       ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                                'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin',
                                'cita.estatus','sucursales.nombreComercial',
                                'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
                       ->where('fecha', '>=', DB::raw('date_format(current_date(),"%y-%m-%d")'))
                       ->where('cita.estatus', '=' , 1)
                       ->where('cita.fk_usuario', '=', $usuario)
                       ->orderBy('cita.fecha', 'desc')->paginate(5);    
        
            // $citas = DB::select('select cita.id,cita.fk_sucursal,cita.fk_auto,cita.comentario,
            // cita.fecha,cita.fk_horario,horarios.horaInicio,horarios.horaFin,
            // cita.estatus,sucursales.nombreComercial,
            // sucursales.direccion,autos.marca,autos.modelo,autos.placa
            // from cita 
            // INNER JOIN sucursales on cita.fk_sucursal = sucursales.id
            // INNER JOIN autos on cita.fk_auto = autos.id
            // INNER JOIN horarios on cita.fk_horario = horarios.id
            // WHERE fecha >= date_format(current_date(),"%y-%m-%d") 
            // AND cita.estatus = 1
            // AND cita.fk_usuario = '.$usuario.' ORDER BY cita.fecha desc LIMIT 5')->get();
          
        return ['citas' => $citas];
    }
    
    public function generarPDF(Request $request){
        
        $usuario = $request->usuario;
        $idCita = $request->idcita;

        $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
                       ->join('autos','cita.fk_auto','=','autos.id')
                       ->join('horarios','cita.fk_horario', '=', 'horarios.id')
                       ->join('users', 'cita.fk_usuario', '=','users.id')
                       ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                                'cita.fecha','cita.fk_horario', 'cita.estatus',
                                'horarios.horaInicio','horarios.horaFin',
                                'sucursales.nombreComercial', 'sucursales.direccion',
                                'autos.marca','autos.modelo','autos.placa',
                                'users.nombre', 'users.apellidoPaterno','users.correo')
                       ->where('fecha', '>=', DB::raw('date_format(current_date(),"%y-%m-%d")'))
                       ->where('cita.estatus', '=' , 1)
                       ->where('cita.fk_usuario', '=', $usuario)
                       ->where('cita.id', '=', $idCita)
                       ->orderBy('cita.fecha', 'desc')->get();
                    
        $numerocliente = DB::select('Select numerocliente from clientes where fk_user = ?',[$usuario]);
    
        $auxhorafecha = Carbon::now('America/Mexico_City');
        $auxSegunda = $auxhorafecha->toDateTimeString();
        $auxTercera = str_replace(' ', '_', $auxSegunda);
        $fechahora = str_replace(':', '', $auxTercera);
        
        $pdf = \PDF::loadView('pdf.comprobanteCitaQR',['citas'=>$citas, 'numerocliente'=>$numerocliente ]);
        return $pdf->download('CitaEnTallerEH'.$idCita.'.pdf');

    }

    public function selectSucursal(Request $request){
        if (!$request->ajax()) return redirect('/');
        $sucursales = Sucursale::where('estatus','=','1')
        ->select('id','nombreComercial', 'direccion')
        ->orderBy('nombreComercial', 'asc')->get();
        return ['sucursales' => $sucursales];
        
    }

    public function listarCitasOrden(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        // $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
        // ->join('autos','cita.fk_auto','=','autos.id')
        // ->join('users','cita.fk_usuario','=','users.id')
        // ->join('clientes','clientes.fk_user','=','users.id')
        // ->join('horarios', 'horarios.id', '=', 'cita.fk_horario')
        // ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
        //          'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horafin','cita.estatus','sucursales.nombreComercial',
        //          'sucursales.direccion','sucursales.cupoAutos','autos.marca','autos.modelo','autos.placa',
        //          'users.nombre','users.apellidoPaterno','users.telefono','users.correo','clientes.id as fk_cliente')
        // ->where('cita.estatus','=','1')
        // ->orderBy('cita.id', 'desc')->paginate(3);

        
        
        // if ($buscar==''){

            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('horarios','cita.fk_horario', '=', 'horarios.id')
            ->join('users','cita.fk_usuario','=','users.id')
            ->join('clientes','clientes.fk_user','=','users.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                    'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin',
                    'cita.estatus','sucursales.nombreComercial',
                    'users.nombre','users.apellidoPaterno','users.telefono','users.correo', 'clientes.id as fk_cliente',
                    'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
            ->where('fecha', '>=', DB::raw('date_format(current_date(),"%y-%m-%d")'))
            ->where('cita.estatus', '=' , 1)
            ->orderBy('cita.fecha', 'desc')->paginate(5);
           
        // }
        // else{

        //     $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
        //     ->join('autos','cita.fk_auto','=','autos.id')
        //     ->join('horarios','cita.fk_horario', '=', 'horarios.id')
        //     ->join('users','cita.fk_usuario','=','users.id')
        //     ->join('clientes','clientes.fk_user','=','users.id')
        //     ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
        //             'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin',
        //             'cita.estatus','sucursales.nombreComercial',
        //             'users.nombre','users.apellidoPaterno','users.telefono','users.correo', 'clientes.id as fk_cliente',
        //             'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
        //     ->where('fecha', '>=', DB::raw('date_format(current_date(),"%y-%m-%d")'))
        //     ->where('cita.'.$criterio, 'like', '%'. $buscar . '%')
        //     ->where('cita.estatus','=', 1)
        //     ->orderBy('cita.fecha', 'desc')->paginate(5);
        // }
        // return [
        //     'pagination' => [
        //         'total'        => $citas->total(),
        //         'current_page' => $citas->currentPage(),
        //         'per_page'     => $citas->perPage(),
        //         'last_page'    => $citas->lastPage(),
        //         'from'         => $citas->firstItem(),
        //         'to'           => $citas->lastItem(),
        //     ],
        //     'citas' => $citas
        // ];
        return [ 'citas' => $citas ];
    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    //Estatus citas : 1 - Autorizada 2 - Cancelada 3 - Atendida
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cita = new Cita();
        $cita->comentario = $request->comentario;
        $cita->fecha = substr($request->fecha,0,10);
        $cita->fk_horario = $request->fk_horario;
        $cita->estatus = 1;
        $cita->fk_auto = $request->fk_auto;
        $cita->fk_usuario = $request->fk_usuario;
        $cita->fk_sucursal = $request->fk_sucursal;
        $cita->save();
    }
    
    public function cancelarCita(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cita::findOrFail($request->id);
        $cliente->estatus = 2;
        $cliente->save();
    }

    public function obtenerCitas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario','cita.estatus','sucursales.nombreComercial',
                     'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
            ->orderBy('cita.id', 'desc')->paginate(10);
        }
        else{
            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario','cita.estatus','sucursales.nombreComercial',
                     'sucursales.direccion','autos.marca','autos.modelo','autos.placa')
            ->where('cita.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('cita.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $citas->total(),
                'current_page' => $citas->currentPage(),
                'per_page'     => $citas->perPage(),
                'last_page'    => $citas->lastPage(),
                'from'         => $citas->firstItem(),
                'to'           => $citas->lastItem(),
            ],
            'citas' => $citas
        ];
    }



    public function listarCitasEmpleados(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('users','cita.fk_usuario','=','users.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario','cita.estatus','sucursales.nombreComercial',
                     'sucursales.direccion','sucursales.cupoAutos','autos.marca','autos.modelo','autos.placa',
                     'users.nombre','users.apellidoPaterno','users.telefono','users.correo')
            ->orderBy('cita.id', 'desc')->paginate(10);
        }
        else{
            $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
            ->join('autos','cita.fk_auto','=','autos.id')
            ->join('users','cita.fk_usuario','=','users.id')
            ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                     'cita.fecha','cita.fk_horario','cita.estatus','sucursales.nombreComercial',
                     'sucursales.direccion','sucursales.cupoAutos','autos.marca','autos.modelo','autos.placa',
                     'users.nombre','users.apellidoPaterno','users.telefono','users.correo')
            ->where('cita.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('cita.fecha', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $citas->total(),
                'current_page' => $citas->currentPage(),
                'per_page'     => $citas->perPage(),
                'last_page'    => $citas->lastPage(),
                'from'         => $citas->firstItem(),
                'to'           => $citas->lastItem(),
            ],
            'citas' => $citas
        ];
    }

    public function listarCitasEmpleadosDia(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $citas = Cita::join('sucursales','cita.fk_sucursal','=','sucursales.id')
        ->join('autos','cita.fk_auto','=','autos.id')
        ->join('users','cita.fk_usuario','=','users.id')
        ->select('cita.id','cita.fk_sucursal','cita.fk_auto','cita.comentario',
                 'cita.fecha','cita.fk_horario','cita.estatus','sucursales.nombreComercial',
                 'sucursales.direccion','autos.marca','autos.modelo','autos.placa',
                 'users.nombre','users.apellidoPaterno','users.telefono','users.correo')
        ->where('cita.fecha','=',$request->fecha)
        ->where('cita.fk_horario','=',$request->fk_horario)
        ->where('cita.id','!=',$request->id)
        ->orderBy('cita.fecha', 'desc')->paginate(10);

        return [
            'pagination' => [
                'total'        => $citas->total(),
                'current_page' => $citas->currentPage(),
                'per_page'     => $citas->perPage(),
                'last_page'    => $citas->lastPage(),
                'from'         => $citas->firstItem(),
                'to'           => $citas->lastItem(),
            ],
            'citas' => $citas
        ];
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $cita = Cita::findOrFail($request->id);
        $cita->fecha = substr($request->fecha,0,10);
        $cita->fk_horario = $request->fk_horario;
        $cita->fk_auto = $request->fk_auto;
        $cita->fk_sucursal = $request->fk_sucursal;
        $cita->save();
    }

    public function autorizarCita(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cita = Cita::findOrFail($request->id);
        $cita->estatus = 1;
        $cita->save();
    }

    public function rechazarCita(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cita = Cita::findOrFail($request->id);
        $cita->estatus = 2;
        $cita->save();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
