<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $tabla='categorias.nombre';
        if($criterio=="nombre") $tabla="productos.nombre";
        
        if ($buscar==''){
            
            $inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
            ->join('categorias','productos.FkidCategoria','=','categorias.id') 
            ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria','categorias.nombre as nombre_categoria','productos.nombre', 
                     'productos.marca', 'productos.modelo','productos.codigoBarras','productos.descripcion',
                     'productos.precioVenta','productos.presentacion','productos.unidad','productos.ventaXpartes','productos.estatus')
            ->orderBy('productos.id', 'desc')->paginate(10);
            
        }
        else{

            $inventarios = Inventario::join('productos','inventarios.fk_producto','=','inventarios.id')
            ->join('categorias','productos.FkidCategoria','=','categorias.id') 
            ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria','categorias.nombre as nombre_categoria','productos.nombre', 
                     'productos.marca', 'productos.modelo','productos.codigoBarras','productos.descripcion',
                     'productos.precioVenta','productos.presentacion','productos.unidad','productos.ventaXpartes','productos.estatus')         
            ->where('productos.'.$criterio.'', 'like', '%'. $buscar. '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
            
            //$inventario = Inventario::WHERE($criterio, 'like', '%'. $buscar . '%')->orderBy('id')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $inventarios->total(),
                'current_page' => $inventarios->currentPage(),
                'per_page'     => $inventarios->perPage(),
                'last_page'    => $inventarios->lastPage(),
                'from'         => $inventarios->firstItem(),
                'to'           => $inventarios->lastItem(),
            ],
            'inventarios' => $inventarios
        ];
    }
    /*
    public function selectinventario(Request $request){
        if (!$request->ajax()) return redirect('/');
        $inventario = inventario::where('estatus','=','1')
        ->select('id','fk_producto','cantidad')->orderBy('fk_producto', 'asc')->get();
        return ['inventario' => $inventario];
    }
    */


    /*
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inventario = new Inventario();

        $inventario->fk_producto = $request->fk_producto;
        $inventario->cantidad = $request->cantidad;
        $inventario->precioCompra = $request->precioCompra;
        $inventario->fechaCompra = $request->fechaCompra;
        $inventario->estatus = '1';
        $inventario->save();
    }
    */

    /*
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inventario = inventario::findOrFail($request->id);
        $inventario->fk_producto = $request->fk_producto;
        $inventario->cantidad = $request->cantidad;
        $inventario->estatus = '1';
        $inventario->save();
    }

    */

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inventario = Inventario::findOrFail($request->id); 
        $inventario->estatus = '0';
        $inventario->save();
    }

 

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inventario = Inventario::findOrFail($request->id);
        $inventario->estatus = '1';
        $inventario->save();
    }
    // Orden Servicio
    public function selectProductoOrden(Request $request){
        //if (!$request->ajax()) return redirect('/');
        
        $inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
            ->join('categorias','productos.FkidCategoria','=','categorias.id') 
            ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria','categorias.nombre as nombre_categoria','productos.nombre', 
                     'productos.marca', 'productos.modelo','productos.codigoBarras','productos.descripcion',
                     'productos.precioVenta','productos.presentacion','productos.unidad','productos.ventaXpartes','productos.estatus')
            ->where('productos.estatus','=','1')
            ->where('inventarios.cantidad','>','0')
            ->orderBy('productos.id', 'desc')->get();
                return $inventarios;
    }
	    public function listarProductoInventario(Request $request)
        {
            //if (!$request->ajax()) return redirect('/');

            $buscar = $request->buscar;
            $criterio = $request->criterio;
            
            if ($buscar==''){
                $inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
                ->join('categorias','productos.FkidCategoria','=','categorias.id') 
                ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria','categorias.nombre as nombre_categoria','productos.nombre', 
                        'productos.marca', 'productos.modelo','productos.codigoBarras','productos.descripcion',
                        'productos.precioVenta','productos.presentacion','productos.unidad','productos.ventaXpartes','productos.estatus')
                ->where('productos.estatus','=','1')
                ->where('inventarios.cantidad','>','0')
                ->orderBy('productos.id', 'desc')->paginate(100);
            }
            else{
                $inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
                ->join('categorias','productos.FkidCategoria','=','categorias.id') 
                ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria','categorias.nombre as nombre_categoria','productos.nombre', 
                        'productos.marca', 'productos.modelo','productos.codigoBarras','productos.descripcion',
                        'productos.precioVenta','productos.presentacion','productos.unidad','productos.ventaXpartes','productos.estatus')
                ->where('productos.estatus','=','1')
                ->where('inventarios.cantidad','>','0')
                ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('productos.id', 'desc')->paginate(100);
            }
            
            return ['productos' => $inventarios];
        }

        public function generarPDF(){
            $inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
            ->join('categorias','productos.FkidCategoria','=','categorias.id') 
            ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria','categorias.nombre as nombre_categoria','productos.nombre', 
                     'productos.marca', 'productos.modelo','productos.codigoBarras','productos.descripcion',
                     'productos.precioVenta','productos.presentacion','productos.unidad','productos.ventaXpartes','productos.estatus')
            ->orderBy('productos.id', 'desc')->get();

            $cont = Inventario::count();
            $auxhorafecha = Carbon::now('America/Mexico_City');
            $fechahora = $auxhorafecha->toDateTimeString();
            $auxSegunda = str_replace(' ', '_', $fechahora);
            $auxTercera = str_replace(':', '', $auxSegunda);
            

            $pdf = \PDF::loadView('pdf.inventariospdf',['inventarios'=>$inventarios, 'cont'=>$cont]);
            return $pdf->download('inventario_'.$auxTercera.'.pdf');

        }
}


