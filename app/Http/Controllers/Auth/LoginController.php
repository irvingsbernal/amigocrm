<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   public function showLoginForm(){
       return view('auth.login');
   }

   public function login(Request $request){
       $this->validateLogin($request);

       if(Auth::attempt(['correo' => $request->correo,
                         'password' => $request->password,
                         'estatus'=> 1,
                         'rol' => 'Cliente'])){
                            // return redirect()->route('main');  index cliente    
       }else if(Auth::attempt(['correo' => $request->correo,
                               'password' => $request->password,
                               'estatus'=> 1,
                               'rol' => 'Administrador'])){
                                return redirect()->route('main');

        }else if(Auth::attempt(['correo' => $request->correo,
                                'password' => $request->password,
                                'estatus'=> 1,
                                'rol' => 'Empleado'])){
                                return redirect()->route('main');

        }else if(Auth::attempt(['correo' => $request->correo,
                                'password' => $request->password,
                                'estatus'=> 1,
                                'rol' => 'Recepcionista'])){
                                return redirect()->route('main');
        }

        return back() ->withErrors(['correo' => trans('auth.failed')])->withInput(request(['correo']));
   } 

protected function validateLogin(Request $request){
    $this->validate($request,[
        'correo' => 'required|string',
        'password' => 'required|string'
    ]);

}

public function logout(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    return redirect('/');
}
}