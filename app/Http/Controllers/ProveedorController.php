<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $proveedores = Proveedor::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $proveedores = Proveedor::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'        => $proveedores->total(),
                'current_page' => $proveedores->currentPage(),
                'per_page'     => $proveedores->perPage(),
                'last_page'    => $proveedores->lastPage(),
                'from'         => $proveedores->firstItem(),
                'to'           => $proveedores->lastItem(),
            ],
            'proveedores' => $proveedores
        ];
    }

    public function selectProveedor(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $proveedores = Proveedor::where('nombreComercial', 'like', '%'. $filtro . '%')
        ->orWhere('razonSocial', 'like', '%'. $filtro . '%')
        ->select('id','nombreComercial','razonSocial')
        ->orderBy('nombreComercial', 'asc')->get();

        return ['proveedores' => $proveedores];
    }

    public function guardar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Proveedor = new Proveedor();
        $Proveedor->nombreComercial = $request->nombreComercial;
        $Proveedor->razonSocial = $request->razonSocial;
        $Proveedor->rfc = $request->rfc;
        $Proveedor->telefono = $request->telefono;
        $Proveedor->correo = $request->correo;
        $Proveedor->direccion = $request->direccion;
        $Proveedor->estatus = '1';
        $Proveedor->save();
    }

    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Proveedor = Proveedor::findOrFail($request->id);
        $Proveedor->nombreComercial = $request->nombreComercial;
        $Proveedor->razonSocial = $request->razonSocial;
        $Proveedor->rfc = $request->rfc;
        $Proveedor->telefono = $request->telefono;
        $Proveedor->correo = $request->correo;
        $Proveedor->direccion = $request->direccion;
        $Proveedor->estatus = '1';
        $Proveedor->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Proveedor = Proveedor::findOrFail($request->id);
        $Proveedor->estatus = '0';
        $Proveedor->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Proveedor = Proveedor::findOrFail($request->id);
        $Proveedor->estatus = '1';
        $Proveedor->save();
    }
}
