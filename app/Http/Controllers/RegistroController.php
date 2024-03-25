<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function showRegistroForm(){
        return view('registro');
    }

    public function showActivacionForm(){
        return view('activacion-cuenta');
    }

    public function registroCliente(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        $users = new User();
        $users->nombre = $request->nombre;
        $users->apellidoPaterno = $request->apellidoPaterno;
        $users->apellidoMaterno = $request->apellidoMaterno;
        $users->telefono = $request->telefono;
        $users->correo = $request->correo;
        $users->password = bcrypt($request->password);
        $users->rol = 'Cliente';
        $users->estatus = 0;
        $users->save();
    
        $cliente = new Cliente();
        $cliente->numerocliente = strtoupper(substr($users->nombre, 0, 2).substr($users->apellidoPaterno, -2, 2).mt_rand(5, 15).'C'.date('Y').date('m').date('d'));
        // $cliente->numerocliente = substr($users->nombre, 0, 2) + substr($users->apellidopaterno, -1, 2) + 'C' + date('Y-m-d');
        $cliente->fk_user = $users->id; 
        $cliente->codigoactivacion = mt_rand();
        $cliente->estatus = 0;
        $cliente->save();

        // $result = (new EmailController)->contact($request, $cliente->codigoactivacion);

        DB::commit();
        return $cliente->codigoactivacion;
    }

    public function activarCuenta(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::where('codigoactivacion', $request->codigoactivacion)->get()->first();
        $users = User::findOrFail($cliente->fk_user);
        $cliente->estatus = 1;
        $cliente->save();
        $users->estatus = 1;
        $users->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
