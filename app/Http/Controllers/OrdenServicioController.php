<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\OrdenProductos;
use App\OrdenServicio;
use App\OrdenSubservicio;
use App\User;
use Carbon\Carbon;

class OrdenServicioController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio; 
        
        if ($buscar==''){

            //$ordenServicio = DB::select('select * from ordenServicio')->paginate(5);
            $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->orderBy('orden_servicio.id', 'desc')->paginate(5);
        }

        if ($criterio=='CLIENTE'){
            $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('nombre','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(5);
        }
        
        if ($criterio=='SUCURSAL'){
            $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('sucursales.nombreComercial','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(5);
        }

        if ($criterio=='EMPLEADO'){
            $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('empleados.noEmpleado','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(5);
        }
        if ($criterio=='ESTADO'){
            $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('orden_servicio.estado','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $ordenServicio->total(),
                'current_page' => $ordenServicio->currentPage(),
                'per_page'     => $ordenServicio->perPage(),
                'last_page'    => $ordenServicio->lastPage(),
                'from'         => $ordenServicio->firstItem(),
                'to'           => $ordenServicio->lastItem(),
            ],
            'ordenServicio' => $ordenServicio
        ];
    }

    public function getOrdenServicio(Request $request)
    {
        /*if (!$request->ajax()) return redirect('/');
            $id = $request->id;
            $ordenServicio =DB::select('select * from ordenServicio where id = ?', [$id]);
            return ['ordenservicio' => $ordenServicio]; */
            if (!$request->ajax()) return redirect('/');
            $id = $request->id;
            $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca','autos.modelo')
            ->WHERE('orden_servicio.id','=',$id)
            ->orderBy('orden_servicio.id', 'desc')->get();

            //$ordenServicio =DB::select('select * from orden_servicio where id = ?', [$id]);
            return ['ordenservicio' => $ordenServicio];  
    }

    public function getOrdenSubservicio(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
            $id = $request->id;
            //$ordenServicio =DB::select('Select *, S.nombre from orden_subservicio INNER JOIN subservicios as S ON S.id= orden_subservicio.fk_subservicio where orden_subservicio.id = ?', [$id]);
            $ordenServicio =DB::select('Select OS.*,OS.precioServicio as precio, S.nombre from orden_subservicio as OS INNER JOIN subservicios as S ON S.id= OS.fk_subservicio where OS.fk_orden = ?', [$id]);
            
            return ['ordenservicio' => $ordenServicio];
    }
    public function getOrdenProductos(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
            $id = $request->id;
            $ordenServicio =DB::select('select P.nombre AS producto,P.ventaXpartes AS partes, P.presentacion, OP.*, OP.precioProducto AS precio from orden_productos AS OP INNER JOIN productos AS P ON P.id=OP.fk_producto WHERE OP.fk_orden = ?', [$id]);
            return ['ordenservicio' => $ordenServicio];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');   

        try{
            DB::beginTransaction();

            if (!$request->ajax()) return redirect('/');
            $ordenServicio = new OrdenServicio();
            $ordenServicio->fk_cliente = $request->fk_cliente;
            $ordenServicio->fk_empleado = $request->fk_empleado;
            $ordenServicio->fk_sucursal = $request->fk_sucursal;
            $ordenServicio->fk_auto = $request->fk_auto;
            if($request->fk_cita!=NULL){
                DB::update('update cita set estatus = 3 where id = ?', [$request->fk_cita]);
                $ordenServicio->fk_cita =$request->fk_cita;      
            }
            
            $ordenServicio->total = $request->total;
            $ordenServicio->estadoSaldo = '0';
            $ordenServicio->estado = 'EN PROCESO'; 
            $ordenServicio->estatus = 1;
            $ordenServicio->save();
            $idOrden = $ordenServicio->id;
            
            foreach ($request->productoAgregar as $value) {
                $ordenProducto = new OrdenProductos();
                $ordenProducto->fk_orden=$idOrden;
                $ordenProducto->cantidad=$value['cantidad'];
                $ordenProducto->precioProducto=$value['precio'];
                $ordenProducto->fk_producto=$value['idProducto'];
                $ordenProducto->save();
             }

             foreach ($request->arrayOrdenservicio as $servicio) {
                $ordenServicio = new OrdenSubservicio();
                $ordenServicio->fk_orden=$idOrden;
                $ordenServicio->fk_subservicio=$servicio['idServicio'];
                $ordenServicio->precioServicio=$servicio['precio'];
                $ordenServicio->estatus=0;
                $ordenServicio->save(); 
             }
        DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ordenServicio = ordenServicio::findOrFail($request->id);
        $ordenServicio->fk_servicio = $request->fk_servicio;
        $ordenServicio->nombre = $request->nombre;
        $ordenServicio->costoServico = $request->costoServico;
        $ordenServicio->estatus = '1';
        $ordenServicio->save();
    }

    public function pagado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ordenServicio = OrdenServicio::findOrFail($request->id);
        $ordenServicio->estadoSaldo = '1';
        $ordenServicio->estado = 'TERMINADA';
        $ordenServicio->save();
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

    public function generarPDF(Request $request){

        $id = $request->idOrden;
        $ordenservicio = OrdenServicio::join('empleados','orden_servicio.fk_empleado','=','empleados.id')
            ->join('sucursales','orden_servicio.fk_sucursal','=','sucursales.id')
            ->join('autos','orden_servicio.fk_auto','=','autos.id')
            ->leftjoin('cita','orden_servicio.fk_cita','=','cita.id')
            ->join('users','empleados.fk_user','=','users.id')
            ->leftjoin('horarios','cita.fk_horario','=','horarios.id')
            ->select('orden_servicio.id','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
                    'orden_servicio.fk_auto', 'orden_servicio.fk_cita',
                    'orden_servicio.total','orden_servicio.estadoSaldo','orden_servicio.estado',
                    'orden_servicio.estatus',
                    'users.nombre','users.apellidoPaterno','users.telefono','users.correo',
                    'sucursales.nombreComercial','sucursales.direccion',
                    'autos.marca','autos.modelo',
                    'cita.fecha','cita.fk_horario','horarios.horaInicio','horarios.horaFin')
            ->where('orden_servicio.id','=',$id)
            ->orderBy('cita.id', 'desc')->get(); 

        $subservicios = OrdenSubservicio::join('subservicios','orden_subservicio.fk_subservicio','=','subservicios.id')
        ->join('servicios','subservicios.fk_servicio','=','servicios.id')
        ->select('orden_subservicio.id','orden_subservicio.precioServicio','orden_subservicio.estatus','subservicios.nombre as subservicio',
        'servicios.nombre as servicio')
        ->where('orden_subservicio.fk_orden','=',$id)
        ->orderBy('orden_subservicio.id', 'desc')->get();

        $productos = OrdenProductos::join('productos','orden_productos.fk_producto','=','productos.id')
        ->join('categorias','productos.FkidCategoria','=','categorias.id')
        ->select('orden_productos.id','productos.nombre','productos.descripcion','productos.marca','categorias.nombre as categoria')
        ->where('orden_productos.fk_orden','=',$id)
        ->orderBy('orden_productos.id', 'desc')->get();

       // $cont = Inventario::count();
        $auxhorafecha = Carbon::now('America/Mexico_City');
        $fechahora = $auxhorafecha->toDateTimeString();
        $auxSegunda = str_replace(' ', '_', $fechahora);
        $auxTercera = str_replace(':', '', $auxSegunda);
        
        $pdf = \PDF::loadView('pdf.vaucherCliente',['ordenservicio'=>$ordenservicio, 'subservicios'=>$subservicios, 'productos'=> $productos ]);
        return $pdf->download('VaucherDeServicio_EH'.$auxTercera.'.pdf');

    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ordenServicio = OrdenServicio::findOrFail($request->id);
        $ordenServicio->estatus = '0';
        $ordenServicio->estado = 'CANCELADO';
        $ordenServicio->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ordenServicio = ordenServicio::findOrFail($request->id);
        $ordenServicio->estatus = '1';
        $ordenServicio->save();
    }

    public function desactivarEmpleado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ordenServicio = OrdenSubservicio::findOrFail($request->id);
        $ordenServicio->estatus = '0';
        $ordenServicio->save();
    }

    public function activarEmpleado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ordenServicio = OrdenSubservicio::findOrFail($request->id);
        $ordenServicio->estatus = '1';
        $ordenServicio->save();
    }

    public function terminarOrden(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $ordenServicio = OrdenServicio::findOrFail($request->id);
        $ordenServicio->estatus = '1';
        $ordenServicio->estado = 'TERMINADA';
        //$ordenServicio->estadoSaldo = '0.00';
        $ordenServicio->save();
        //$idSucursal= DB::select('select fk_sucursal from orden_servicio where id = ?', [$request->]);
        DB::update('update sucursales set stockCupo = stockCupo + 1 where id = ?', [$request->idSucursal]);
    }
    public function listarOrdenMecanico(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $usuario = $request->idUsuario;
        
        $Empleado =DB::select('select id from empleados where fk_user = ?', [$usuario]);
        $id=$Empleado[0]->id;


        if ($buscar==''){

            //$ordenServicio = DB::select('select * from ordenServicio')->paginate(5);
            $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'sucursales.nombreComercial','autos.marca')
            ->WHERE('orden_servicio.fk_empleado','=',$id)
            ->orderBy('orden_servicio.id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $ordenServicio->total(),
                'current_page' => $ordenServicio->currentPage(),
                'per_page'     => $ordenServicio->perPage(),
                'last_page'    => $ordenServicio->lastPage(),
                'from'         => $ordenServicio->firstItem(),
                'to'           => $ordenServicio->lastItem(),
            ],
            'ordenServicio' => $ordenServicio
        ];    
}

public function listarOrdenAdmin(Request $request){
    $buscar = $request->buscar;
    $criterio = $request->criterio;
    
    if ($buscar==''){

        //$ordenServicio = DB::select('select * from ordenServicio')->paginate(5);
        $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
        ->join('users','users.id','=','clientes.fk_user')
        ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
        ->join('autos','autos.id','=','orden_servicio.fk_auto')
        ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
        'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
        'orden_servicio.estatus',
        (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
        'sucursales.nombreComercial','autos.marca')
        ->orderBy('orden_servicio.estado', 'asc')
        ->orderBy('orden_servicio.id', 'desc')
        ->paginate(10);
    }
    if ($criterio=='CLIENTE'){
        $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
        ->join('users','users.id','=','clientes.fk_user')
        ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
        ->join('autos','autos.id','=','orden_servicio.fk_auto')
        ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
        'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
        'orden_servicio.estatus',
        (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
        'sucursales.nombreComercial','autos.marca')
        ->where('nombre','like', '%'. $buscar .'%')
        ->orderBy('orden_servicio.id', 'desc')->paginate(10);
    }
    
    if ($criterio=='SUCURSAL'){
        $ordenServicio = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
        ->join('users','users.id','=','clientes.fk_user')
        ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
        ->join('autos','autos.id','=','orden_servicio.fk_auto')
        ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
        'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
        'orden_servicio.estatus',
        (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
        'sucursales.nombreComercial','autos.marca')
        ->where('sucursales.nombreComercial','like', '%'. $buscar . '%')
        ->orderBy('orden_servicio.id', 'desc')->paginate(10);
    }
    return [
        'pagination' => [
            'total'        => $ordenServicio->total(),
            'current_page' => $ordenServicio->currentPage(),
            'per_page'     => $ordenServicio->perPage(),
            'last_page'    => $ordenServicio->lastPage(),
            'from'         => $ordenServicio->firstItem(),
            'to'           => $ordenServicio->lastItem(),
        ],
        'ordenServicio' => $ordenServicio
    ];    
}
    public function obtenerOrdenesFinalizadas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio; 
        
        if ($buscar==''){

            //$ordenServicio = DB::select('select * from ordenServicio')->paginate(5);
            $ordenesFinalizadas = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('orden_servicio.estado','like', '%TERMINADA%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(10);
        }

        if ($criterio=='CLIENTE'){
            $ordenesFinalizadas = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('orden_servicio.estado','like', '%TERMINADA%')
            ->where('nombre','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(10);
        }
        
        if ($criterio=='SUCURSAL'){
            $ordenesFinalizadas = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('sucursales.nombreComercial','like', '%'. $buscar . '%')
            ->where('orden_servicio.estado','like', '%TERMINADA%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(10);
        }

        if ($criterio=='EMPLEADO'){
            $ordenesFinalizadas = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('orden_servicio.estado','like', '%TERMINADA%')
            ->where('empleados.noEmpleado','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'        => $ordenesFinalizadas->total(),
                'current_page' => $ordenesFinalizadas->currentPage(),
                'per_page'     => $ordenesFinalizadas->perPage(),
                'last_page'    => $ordenesFinalizadas->lastPage(),
                'from'         => $ordenesFinalizadas->firstItem(),
                'to'           => $ordenesFinalizadas->lastItem(),
            ],
            'ordenesFinalizadas' => $ordenesFinalizadas
        ];
    }

    public function obtenerOrdenesFinalizadasEmpleado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio; 
        $usuario = $request->usuario;
        
        $Empleado =DB::select('select id from empleados where fk_user = ?', [$usuario]);
        $id=$Empleado[0]->id;
        
        if ($buscar==''){

            //$ordenServicio = DB::select('select * from ordenServicio')->paginate(5);
            $ordenesFinalizadasEmp = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('orden_servicio.estado','like', '%TERMINADA%')
            ->where('orden_servicio.fk_empleado', '=' , $id)
            ->orderBy('orden_servicio.id', 'desc')->paginate(10);
        }

        if ($criterio=='CLIENTE'){
            $ordenesFinalizadasEmp = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('orden_servicio.estado','like', '%TERMINADA%')
            ->where('orden_servicio.fk_empleado', '=' , $id)
            ->where('nombre','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(10);
        }
        
        if ($criterio=='SUCURSAL'){
            $ordenesFinalizadasEmp = ordenServicio::join('clientes','clientes.id','=','orden_servicio.fk_cliente')
            ->join('users','users.id','=','clientes.fk_user')
            ->join('empleados','empleados.id','=','orden_servicio.fk_empleado')
            ->join('sucursales','sucursales.id','=','orden_servicio.fk_sucursal')
            ->join('autos','autos.id','=','orden_servicio.fk_auto')
            ->select('orden_servicio.id', 'orden_servicio.fk_cliente','orden_servicio.fk_empleado','orden_servicio.fk_sucursal',
            'orden_servicio.fk_auto','orden_servicio.fk_cita','orden_servicio.total', 'orden_servicio.estadoSaldo','orden_servicio.estado',
            'orden_servicio.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'empleados.noEmpleado','sucursales.nombreComercial','autos.marca')
            ->where('orden_servicio.estado','like', '%TERMINADA%')
            ->where('orden_servicio.fk_empleado', '=' , $id)
            ->where('sucursales.nombreComercial','like', '%'. $buscar . '%')
            ->orderBy('orden_servicio.id', 'desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $ordenesFinalizadasEmp->total(),
                'current_page' => $ordenesFinalizadasEmp->currentPage(),
                'per_page'     => $ordenesFinalizadasEmp->perPage(),
                'last_page'    => $ordenesFinalizadasEmp->lastPage(),
                'from'         => $ordenesFinalizadasEmp->firstItem(),
                'to'           => $ordenesFinalizadasEmp->lastItem(),
            ],
            'ordenesFinalizadasEmp' => $ordenesFinalizadasEmp
        ];
    }
}
