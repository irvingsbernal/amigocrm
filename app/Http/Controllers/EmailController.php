<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{
    public function contact(Request $request, $codigo){
        $subject = "Código de activación";
        $for = $request->correo;
        $data = ['foo' => $codigo, 'nombre' => $request->nombre.' '.$request->apellidoPaterno];
        Mail::send('email',$data, function($msj) use($subject,$for){
            $msj->from("ecrouhexagonal@gmail.com","ÉCROU HEXAGONAL");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back();
    }
}

