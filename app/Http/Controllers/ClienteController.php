<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $clientes = Cliente::all();
        // return $clientes;
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $clientes = Cliente::join('users','clientes.fk_user','=','users.id')
            ->select('clientes.id','clientes.fk_user','users.nombre','users.apellidoPaterno',
                     'users.apellidoMaterno','users.rfc','users.direccion','users.telefono',
                     'users.foto','clientes.numerocliente','users.correo','users.password',
                     'clientes.estatus')
            ->orderBy('clientes.id', 'desc')->paginate(10);
        }
        else{

            $clientes = Cliente::join('users','clientes.fk_user','=','users.id')
            ->select('clientes.id','clientes.fk_user','users.nombre','users.apellidoPaterno',
                     'users.apellidoMaterno','users.rfc','users.direccion','users.telefono',
                     'users.foto','clientes.numerocliente','users.correo','users.password',
                     'clientes.estatus')->where('users.'.$criterio, '=', $buscar)
            ->orderBy('clientes.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $clientes->total(),
                'current_page' => $clientes->currentPage(),
                'per_page'     => $clientes->perPage(),
                'last_page'    => $clientes->lastPage(),
                'from'         => $clientes->firstItem(),
                'to'           => $clientes->lastItem(),
            ],
            'clientes' => $clientes
        ];
    }

    public function selectClienteOrden(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $cliente = Cliente::join('users','clientes.fk_user','=','users.id')
            ->select('clientes.id','clientes.fk_user','clientes.numerocliente','clientes.estatus',
            (DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno) AS nombre")))
            ->where('users.rol', '=', 'Cliente')
            ->where(DB::raw("CONCAT(users.nombre,' ',users.apellidoPaterno,' ',users.apellidoMaterno)"), 'LIKE', "%".$filtro."%")
            ->orderBy('clientes.numerocliente', 'desc')->get();

        return ['clientes' => $cliente];
    }

    public function selectCliente(Request $request){
        if (!$request->ajax()) return redirect('/');
        $clientes = Cliente::where('estatus','=','1')
        ->select('id','numerocliente')->orderBy('numerocliente', 'asc')->get();
        return ['clientes' => $clientes];
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
        if (!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        $users = new User();
        $users->nombre = $request->nombre;
        $users->apellidoPaterno = $request->apellidoPaterno;
        $users->apellidoMaterno = $request->apellidoMaterno;
        $users->rfc = strtoupper($request->rfc);
        $users->direccion = $request->direccion;
        $users->telefono = $request->telefono;
        $users->foto = $request->foto;
        $users->correo = $request->correo;
        $users->password = bcrypt($request->password);
        $users->rol = 'Cliente';
        $users->estatus = 1;
        $users->save();
    
        $cliente = new Cliente();
        $cliente->numerocliente = strtoupper(substr($users->nombre, 0, 2).substr($users->apellidoPaterno, -2, 2).mt_rand(5, 15).'C'.date('Y').date('m').date('d'));
        // $cliente->numerocliente = substr($users->nombre, 0, 2) + substr($users->apellidopaterno, -1, 2) + 'C' + date('Y-m-d');
        $cliente->fk_user = $users->id; 
        $cliente->codigoactivacion = mt_rand();
        $cliente->estatus = 1;
        $cliente->save();

        // $result = (new EmailController)->contact($request, $cliente->codigoactivacion);

        DB::commit();
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
        // DB::table('cliente')->where('id', $request->id)->update(['estatus' => 0]);
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $cliente = Cliente::findOrFail($request->id);
            $users = User::findOrFail($cliente->fk_user);
            $users->nombre = $request->nombre;
            $users->apellidoPaterno = $request->apellidoPaterno;
            $users->apellidoMaterno = $request->apellidoMaterno;
            $users->rfc = strtoupper($request->rfc);
            $users->direccion = $request->direccion;
            $users->telefono = $request->telefono;
            $users->foto = $request->foto;
            $users->correo = $request->correo;
            $users->password = bcrypt($request->password);
            $users->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->estatus = 0;
        $cliente->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->estatus = 1;
        $cliente->save();
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