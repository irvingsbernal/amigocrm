<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Horarios;
use App\Sucursale;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){

            $horarios = Horarios::join('sucursales','horarios.fk_sucursal','=','sucursales.id')
            ->select('horarios.id','horarios.horaInicio','horarios.horaFin',
            'horarios.fk_sucursal')
            ->orderBy('horarios.id', 'desc')->paginate(3);
        }
        else{

            $horarios = Horarios::join('sucursales','horarios.fk_sucursal','=','sucursales.id')
            ->select('horarios.id','horarios.horaInicio','horarios.horaFin',
            'horarios.fk_sucursal')
            ->where('horarios.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('horarios.id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $horarios->total(),
                'current_page' => $horarios->currentPage(),
                'per_page'     => $horarios->perPage(),
                'last_page'    => $horarios->lastPage(),
                'from'         => $horarios->firstItem(),
                'to'           => $horarios->lastItem(),
            ],
            'horarios' => $horarios
        ];
    }

    public function obtenerHorarioPorSucursal(Request $request){
        if (!$request->ajax()) return redirect('/');
        
        $horarios = DB::select('SELECT * FROM horarios WHERE id 
                                NOT IN(SELECT fk_horario from cita where fecha = ? and fk_sucursal = ? and estatus = 1 or estatus = 3)', [$request->fecha, $request->fk_sucursal]);
                              //NOT IN(SELECT fk_horario from cita where fecha = DATE_SUB(?,INTERVAL 24 HOUR) and fk_sucursal = ?)', [$request->fecha, $request->fk_sucursal]);
            // $horarios = Horarios::leftJoin('cita','horarios.id','=','cita.fk_horario')
            // ->select('horarios.id','horarios.horaInicio','horarios.horaFin',
            // 'horarios.fk_sucursal')
            // ->where('horarios.fk_sucursal', '=', $request->fk_sucursal)
            // //->orderBy('horarios.id', 'desc')
            // ->orderBy('horarios.horaInicio', 'asc')
            // ->get();

            return ['horarios' => $horarios];
    }

    
}


