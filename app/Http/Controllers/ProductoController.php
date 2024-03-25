<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('categorias','productos.FkidCategoria','=','categorias.id')
            ->select('productos.id','productos.FkidCategoria','productos.codigoBarras','productos.nombre','categorias.nombre as nombre_categoria','productos.precioVenta','productos.precioCompra','productos.ventaXpartes','productos.marca','productos.modelo','productos.presentacion','productos.unidad', 'productos.imagen', 'productos.descripcion','productos.estatus')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('categorias','productos.FkidCategoria','=','categorias.id')
            ->select('productos.id','productos.FkidCategoria','productos.codigoBarras','productos.nombre','categorias.nombre as nombre_categoria','productos.precioVenta','productos.precioCompra','productos.ventaXpartes','productos.marca','productos.modelo', 'productos.imagen','productos.descripcion','productos.estatus')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }

    public function listarProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('categorias','productos.FkidCategoria','=','categorias.id')
            ->select('productos.id','productos.FkidCategoria','productos.codigoBarras','productos.nombre',
            'categorias.nombre as nombre_categoria','productos.precioVenta','productos.precioCompra',
            'productos.ventaXpartes','productos.marca','productos.modelo','productos.presentacion',
            'productos.unidad','productos.descripcion','productos.estatus')
            ->orderBy('productos.id', 'desc')->paginate(100);
        }
        else{
            $productos = Producto::join('categorias','productos.FkidCategoria','=','categorias.id')
            ->select('productos.id','productos.FkidCategoria','productos.codigoBarras','productos.nombre',
            'categorias.nombre as nombre_categoria','productos.precioVenta','productos.precioCompra',
            'productos.ventaXpartes','productos.marca','productos.modelo','productos.descripcion',
            'productos.estatus')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(100);
        }
        
        return ['productos' => $productos];
    }


    public function buscarProducto(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('codigoBarras','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['productos' => $productos];
    }

 /*
    public function listarproductoVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigoBarras','productos.nombre','categorias.nombre as nombre_categoria','productos.precioVenta','productos.stock','productos.descripcion','productos.estatus')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigoBarras','productos.nombre','categorias.nombre as nombre_categoria','productos.precioVenta','productos.stock','productos.descripcion','productos.estatus')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return ['productos' => $productos];
    }

    public function buscarproductoVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('codigoBarras','=', $filtro)
        ->select('id','nombre','stock','precioVenta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['productos' => $productos];
    }
    */
    public function guardar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = new Producto();
        $producto->FkidCategoria = $request->FkidCategoria;
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->modelo = $request->modelo;
        $producto->presentacionInterfaz = $request->presentacionInterfaz;
        $producto->presentacion = $request->presentacion;
        $producto->unidad = $request->unidad;
        $producto->descripcion = $request->descripcion;
        $producto->codigoBarras = $request->codigoBarras;
        $producto->precioCompra = $request->precioCompra;
        $producto->precioVenta = $request->precioVenta;
        $producto->imagen = $request->imagen;
        $producto->ventaXpartes = $request->ventaXpartes;
        $producto->estatus = '1';
        $producto->save();
    }
    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->FkidCategoria = $request->FkidCategoria;
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->modelo = $request->modelo;
        $producto->presentacionInterfaz = $request->presentacionInterfaz;
        $producto->presentacion = $request->presentacion;
        $producto->unidad = $request->unidad;
        $producto->descripcion = $request->descripcion;
        $producto->codigoBarras = $request->codigoBarras;
        $producto->precioCompra = $request->precioCompra;
        $producto->precioVenta = $request->precioVenta;
        $producto->imagen = $request->imagen;
        $producto->ventaXpartes = $request->ventaXpartes;
        $producto->estatus = '1';
        $producto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->estatus = '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->estatus = '1';
        $producto->save();
    }



}
