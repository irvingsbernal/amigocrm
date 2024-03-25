<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Empleado;
use App\Persona;
use App\User;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $empleados = Empleado::join('puestos','empleados.fk_puesto','=','puestos.id')
            ->join('users', 'empleados.fk_user', '=', 'users.id')
            ->select('empleados.id','empleados.noEmpleado','empleados.nss','empleados.estatus',
             'empleados.fk_user','empleados.fk_puesto',
            'puestos.nombre as puesto','users.nombre',
            'users.apellidoPaterno','users.apellidoMaterno','users.rfc','users.direccion',
            'users.telefono','users.foto',
            'users.correo','users.rol')
            ->orderBy('empleados.id', 'desc')->paginate(5);
        }
        elseif ($criterio=='nombre'){
            $empleados = Empleado::join('puestos','empleados.fk_puesto','=','puestos.id')
            ->join('users', 'empleados.fk_user', '=', 'users.id')
            ->select('empleados.id','empleados.noEmpleado','empleados.nss','empleados.estatus',
             'empleados.fk_user','empleados.fk_puesto',
            'puestos.nombre as puesto','users.nombre',
            'users.apellidoPaterno','users.apellidoMaterno','users.rfc','users.direccion',
            'users.telefono','users.foto',
            'users.correo','users.rol')
            ->where(DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno)"), 'LIKE', "%".$buscar."%")
            ->orderBy('empleados.noEmpleado', 'desc')->paginate(5);
        }
        else{
            
            $empleados = Empleado::join('puestos','empleados.fk_puesto','=','puestos.id')
            ->join('users', 'empleados.fk_user', '=', 'users.id')
            ->select('empleados.id','empleados.noEmpleado','empleados.nss','empleados.estatus',
             'empleados.fk_user','empleados.fk_puesto',
            'puestos.nombre as puesto','users.nombre',
            'users.apellidoPaterno','users.apellidoMaterno','users.rfc','users.direccion',
            'users.telefono','users.foto',
            'users.correo','users.rol')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('empleados.id', 'desc')->paginate(5);
        }
        
        return [
            'pagination' => [
                'total'        => $empleados->total(),
                'current_page' => $empleados->currentPage(),
                'per_page'     => $empleados->perPage(),
                'last_page'    => $empleados->lastPage(),
                'from'         => $empleados->firstItem(),
                'to'           => $empleados->lastItem(),
            ],
            'empleados' => $empleados
        ];
    }

    public function guardar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            
            DB::beginTransaction();
            $user = new User();
            $user->nombre = $request->nombre;
            $user->apellidoPaterno = $request->apellidoPaterno;
            $user->apellidoMaterno = $request->apellidoMaterno;
            $user->rfc = strtoupper($request->rfc);
            $user->direccion = $request->direccion;
            $user->telefono = $request->telefono;
            $user->foto = $request->foto;
            //OJO CON EL RFC AL TESTEAR 
            //$user->correo = $request->nombre . '.' . $request->apellidoPaterno .'.'. substr($request->rfc, 7, 4) . '@' . 'ecrouhex.com';
            $user->correo = strtolower($request->rfc) . '@' . 'ecrouhex.com';
            $user->password = bcrypt($request->password);
            $user->rol = $request->rol;
            $user->estatus = '1';
            $user->save();

            $empleado = new Empleado();
            $empleado->noEmpleado = 'e'.$user->id;
            $empleado->nss = strtoupper($request->nss);
            $empleado->fk_user = $user->id;
            $empleado->fk_puesto = $request->fk_puesto;
            $empleado->estatus = '1';
            $empleado->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function seleccionarEmpleado(Request $request){
        if (!$request->ajax()) return redirect('/');
        $empleados = Empleado::where('estatus','=','1')
        ->select('id','noEmpleado')->orderBy('noEmpleado', 'asc')->get();
        return ['empleados' => $empleados];
    }

    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{

            DB::beginTransaction();

            //Busqueda de registro por actualizar
            $empleado = Empleado::findOrFail($request->id);
            $user = User::findOrFail($empleado->fk_user);

            $user->nombre = $request->nombre;
            $user->apellidoPaterno = $request->apellidoPaterno;
            $user->apellidoMaterno = $request->apellidoMaterno;
            $user->rfc = strtoupper($request->rfc);
            $user->direccion = $request->direccion;
            $user->telefono = $request->telefono;
            $user->foto = $request->foto;
            //OJO CON EL RFC AL TESTEAR 
            //$user->correo = $request->nombre . '.' . $request->apellidoPaterno .'.'. substr($request->rfc, 7, 4) . '@' . 'ecrouhex.com';
            $user->correo = strtolower($request->rfc) . '@' . 'ecrouhex.com';
            $user->password = bcrypt($request->password);
            $user->rol = $request->rol;
            $user->estatus = '1';
            $user->save();

            $empleado->nss = strtoupper($request->nss);
            $empleado->fk_puesto = $request->fk_puesto;
            $empleado->save();

            
            
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }
    
//ELIMINACIÓN DE FORMA LÓGICA:
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();

            //Busqueda de registro por actualizar
            $empleado = Empleado::findOrFail($request->id);
            $user = User::findOrFail($empleado->fk_user);

            $user->estatus = '0';
            $user->save();

            $empleado->estatus = '0';
            $empleado->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();

            //Busqueda de registro por actualizar
            $empleado = Empleado::findOrFail($request->id);
            $user = User::findOrFail($empleado->fk_user);

            $user->estatus = '1';
            $user->save();

            $empleado->estatus = '1';
            $empleado->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }
	
	public function selectEmpleadoOrden(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $empleados = Empleado::join('users','empleados.fk_user','=','users.id')
            ->select('empleados.id','empleados.noEmpleado','empleados.nss','empleados.estatus',
            'empleados.fk_user', 
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")),
            'users.apellidoPaterno','users.apellidoMaterno','users.rfc','users.direccion',
            'users.telefono','users.rol')
            ->WHERE('users.rol','=','Empleado')
            ->where(DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno)"), 'LIKE', "%".$filtro."%")
            ->orderBy('empleados.noEmpleado', 'desc')->get();
            
        return ['empleados' => $empleados];
    }
}
