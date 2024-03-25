<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\DetalleIngreso;

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){

            $ingresos = Ingreso::join('proveedores','ingresos.fk_proveedor','=','proveedores.id')
            ->join('users','ingresos.fk_user','=','users.id')
            ->select('ingresos.id','ingresos.documento','ingresos.serieDocumento',
            'ingresos.noDocumento','ingresos.fechaHora','ingresos.impuesto','ingresos.total',
            'ingresos.estatus','proveedores.nombreComercial','users.nombre', 'users.apellidoPaterno', 'users.correo')
            ->orderBy('ingresos.id', 'desc')->paginate(10);
        }
        else{
            $ingresos = Ingreso::join('proveedores','ingresos.fk_proveedor','=','proveedores.id')
            ->join('users','ingresos.fk_user','=','users.id')
            ->select('ingresos.id','ingresos.documento','ingresos.serieDocumento',
            'ingresos.noDocumento','ingresos.fechaHora','ingresos.impuesto','ingresos.total',
            'ingresos.estatus','proveedores.nombreComercial','users.nombre', 'users.apellidoPaterno', 'users.correo')
            ->where('ingresos.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('ingresos.id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }

    public function obtenerIngreso(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $ingresos = Ingreso::join('proveedores','ingresos.fk_proveedor','=','proveedores.id')
            ->join('users','ingresos.fk_user','=','users.id')
            ->select('ingresos.id','ingresos.documento','ingresos.serieDocumento',
            'ingresos.noDocumento','ingresos.fechaHora','ingresos.impuesto','ingresos.total',
            'ingresos.estatus','proveedores.nombreComercial','users.nombre', 'users.apellidoPaterno', 'users.correo')
        ->where('ingresos.id','=',$id)
        ->orderBy('ingresos.id', 'desc')->take(1)->get();
        
        return ['ingreso' => $ingresos];
    }
    public function obtenerDetallesDeIngreso(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleIngreso::join('productos','detalleIngresos.fk_producto','=','productos.id')
        ->select('detalleIngresos.cantidad','detalleIngresos.precio','productos.nombre as producto')
        ->where('detalleIngresos.fk_ingreso','=',$id)
        ->orderBy('detalleIngresos.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }

    public function guardar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            
            DB::beginTransaction();

            $auxhorafecha = Carbon::now('America/Mexico_City');

            $ingreso = new Ingreso();
            $ingreso->fk_proveedor = $request->fk_proveedor;
            $ingreso->fk_user = \Auth::user()->id;
            $ingreso->documento = $request->documento;
            $ingreso->serieDocumento = $request->serieDocumento;
            $ingreso->noDocumento = $request->noDocumento;
            $ingreso->fechaHora = $auxhorafecha->toDateTimeString();
            //toRfc850String ()
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->estatus = 'En inventario';
            $ingreso->save();

            //Arreglo con los detalles
            $detalles = $request->data;

            //Recorro todos los elementos
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->fk_ingreso = $ingreso->id;
                $detalle->fk_producto = $det['fk_producto'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();
            }          

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function anular(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estatus = 'Cancelado';
        $ingreso->save();
    }
}

