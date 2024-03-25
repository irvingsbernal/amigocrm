<?php

namespace App\Http\Controllers;

use App\Auto;
use App\Cliente;
use App\OrdenProductos;
use App\OrdenServicio;
use App\OrdenSubservicio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function listarAutosCliente(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $autos = Auto::join('clientes','autos.fk_cliente','=','clientes.id')
        ->join('users','clientes.fk_user','=','users.id')
        ->select('autos.id','autos.fk_cliente','autos.marca','autos.modelo','autos.anio','autos.numerovinserie','autos.color','autos.placa','autos.kilometraje','autos.fotografia','autos.estatus')
        ->where('users.id','=',$request->idUsuario)
        ->orderBy('autos.id', 'desc')->paginate(3);
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

    public function serviciosCliente(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = $request->fk_cliente;
            $ordenservicio = OrdenServicio::join('empleados','orden_servicio.fk_empleado','=','empleados.id')
            ->join('sucursales','orden_servicio.fk_sucursal','=','sucursales.id')
            ->join('autos','orden_servicio.fk_auto','=','autos.id')
            ->leftjoin('cita','orden_servicio.fk_cita','=','cita.id')
            ->join('users','empleados.fk_user','=','users.id')
            ->join('horarios','cita.fk_horario','=','horarios.id')
            ->select('orden_servicio.id','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
                    'orden_servicio.fk_auto', 'orden_servicio.fk_cita',
                    'orden_servicio.total','orden_servicio.estadoSaldo','orden_servicio.estado',
                    'orden_servicio.estatus',
                    'users.nombre','users.apellidoPaterno','users.telefono','users.correo',
                    'sucursales.nombreComercial','sucursales.direccion',
                    'autos.marca','autos.modelo',
                    'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin')
            ->where('orden_servicio.fk_cliente','=',$cliente)
            ->orderBy('cita.id', 'desc')->paginate(3);  


        return [
            'pagination' => [
                'total'        => $ordenservicio->total(),
                'current_page' => $ordenservicio->currentPage(),
                'per_page'     => $ordenservicio->perPage(),
                'last_page'    => $ordenservicio->lastPage(),
                'from'         => $ordenservicio->firstItem(),
                'to'           => $ordenservicio->lastItem(),
            ],
            'ordenservicio' => $ordenservicio
        ];
    }

    public function obtenerProductosServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $productos = OrdenProductos::join('productos','orden_productos.fk_producto','=','productos.id')
        ->join('categorias','productos.FkidCategoria','=','categorias.id')
        ->select('orden_productos.id','productos.nombre','productos.descripcion','productos.marca','categorias.nombre as categoria')
        ->where('orden_productos.fk_orden','=',$request->id_orden)
        ->orderBy('orden_productos.id', 'desc')->paginate(3);
        return [
            'productos' => $productos
        ];
    }

    public function obtenerSubservicioServicio(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $subservicios = OrdenSubservicio::join('subservicios','orden_subservicio.fk_subservicio','=','subservicios.id')
        ->join('servicios','subservicios.fk_servicio','=','servicios.id')
        ->select('orden_subservicio.id','orden_subservicio.precioServicio','orden_subservicio.estatus','subservicios.nombre as subservicio',
        'servicios.nombre as servicio')
        ->where('orden_subservicio.fk_orden','=',$request->id_orden)
        ->orderBy('orden_subservicio.id', 'desc')->paginate(3);
        return [
            'subservicios' => $subservicios
        ];
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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