<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Finanzas;

class FinanzasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $finanzas = Finanzas::select('finanzas.id','finanzas.registro','finanzas.tipo','finanzas.concepto',
                     'finanzas.monto','finanzas.fecha','finanzas.estatus','finanzas.documento',
                     'finanzas.serieDocumento','finanzas.noDocumento')
            ->orderBy('finanzas.id', 'desc')->paginate(5);
        }
        else{

            $finanzas = Cliente::select('finanzas.id','finanzas.registro','finanzas.tipo','finanzas.concepto',
            'finanzas.monto','finanzas.fecha','finanzas.estatus','finanzas.documento',
            'finanzas.serieDocumento','finanzas.noDocumento')
            ->where('finanzas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('finanzas.id', 'desc')->paginate(5);
        }
        

        return [
            'pagination' => [
                'total'        => $finanzas->total(),
                'current_page' => $finanzas->currentPage(),
                'per_page'     => $finanzas->perPage(),
                'last_page'    => $finanzas->lastPage(),
                'from'         => $finanzas->firstItem(),
                'to'           => $finanzas->lastItem(),
            ],
            'finanzas' => $finanzas
        ];
    }

    public function guardar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finanzas = new Finanzas();
        $finanzas->registro = $request->registro;
        $finanzas->tipo = $request->tipo;
        $finanzas->concepto = $request->concepto;
        $finanzas->fecha = $request->fecha;
        $finanzas->registro = $request->registro;
        $finanzas->monto = $request->monto;
        $finanzas->documento = $request->documento;
        $finanzas->serieDocumento = $request->serieDocumento;
        $finanzas->noDocumento = $request->noDocumento;
        $finanzas->estatus = '1';
        $finanzas->save();
    }

    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finanzas = Finanzas::findOrFail($request->id);
        $finanzas->registro = $request->registro;
        $finanzas->tipo = $request->tipo;
        $finanzas->concepto = $request->concepto;
        $finanzas->fecha = $request->fecha;
        $finanzas->registro = $request->registro;
        $finanzas->monto = $request->monto;
        $finanzas->documento = $request->documento;
        $finanzas->serieDocumento = $request->serieDocumento;
        $finanzas->noDocumento = $request->noDocumento;
        $finanzas->estatus = '1';
        $finanzas->save();
    }

 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finanzas = Finanzas::findOrFail($request->id);
        $finanzas->estatus = '0';
        $finanzas->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finanzas = Finanzas::findOrFail($request->id);
        $finanzas->estatus = '1';
        $finanzas->save();
    }

    public function seleccionarAnios(Request $request){
        if (!$request->ajax()) return redirect('/');
        $anios = DB::select('SELECT 
        SUBSTRING(fecha,1,4) as anio 
        FROM 
        finanzas 
        WHERE estatus = 1 
        GROUP BY anio');
        return ['anios' => $anios];
    }

    public function datosReporte(Request $request){
        if (!$request->ajax()) return redirect('/');
        
       
            $ingresos = DB::select('SELECT 
            sum(monto) AS monto,
            SUBSTRING(fecha,6,2) AS mes 
            FROM 
            finanzas 
            WHERE estatus = 1 AND registro = "Ingreso" AND SUBSTRING(fecha,1,4) = ?
            GROUP BY registro, SUBSTRING(fecha,1,4), mes 
            ORDER BY SUBSTRING(fecha,6,2)',[$request->anio]);

            $gastos = DB::select('SELECT 
            sum(monto) AS monto,
            SUBSTRING(fecha,6,2) AS mes  
            FROM 
            finanzas 
            WHERE estatus = 1 AND registro = "Gasto" AND SUBSTRING(fecha,1,4) = ?
            GROUP BY registro, SUBSTRING(fecha,1,4), mes
            ORDER BY SUBSTRING(fecha,6,2)',[$request->anio]);

            $saldos = DB::select('SELECT SUM(monto) AS monto,
            mes FROM (SELECT 
            registro, 
            SUBSTRING(fecha,1,4) as anio, 
            SUBSTRING(fecha,6,2) as mes, 
            IF(registro="Ingreso",sum(monto),(sum(monto)*-1)) AS monto 
            FROM 
            finanzas 
            WHERE estatus = 1 
            GROUP BY registro, anio, mes 
            ORDER BY mes) C
            WHERE C.anio = ?
            GROUP BY C.mes',[$request->anio]);

        return [
            'reporte' => [
                'ingresos' => $ingresos,
                'gastos' => $gastos,
                'saldos' => $saldos,
            ]
        ];
    }

    public function mesesIngresos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $meses = DB::select('SELECT SUBSTRING(fecha,6,2) AS mes, 
        SUM(monto) AS monto,
        COUNT(SUBSTRING(fecha,6,2)) AS total
        FROM finanzas 
        WHERE SUBSTRING(fecha,1,4) = ?
        AND registro = "Ingreso"
        AND estatus = 1 
        GROUP BY mes 
        ORDER BY mes',
        [$request->anio]);
        
        return ['meses' => $meses];
    }

    public function IngresosMes(Request $request){
        if (!$request->ajax()) return redirect('/');
        $ingresos = DB::select('SELECT 
        tipo,
        SUBSTRING(fecha,6,2) AS mes,
        SUM(monto) AS monto,
        COUNT(tipo) AS total 
        FROM finanzas 
        WHERE SUBSTRING(fecha,1,4) = ?
        AND SUBSTRING(fecha,6,2) = ?
        AND registro = "Ingreso" 
        AND estatus = 1  
        GROUP BY tipo, mes, monto
        ORDER BY mes;',
        [$request->anio,$request->mes]);
        
        return ['ingresos' => $ingresos];
    }

    public function mesesGastos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $meses = DB::select('SELECT SUBSTRING(fecha,6,2) AS mes, 
        SUM(monto) AS monto,
        COUNT(SUBSTRING(fecha,6,2)) AS total
        FROM finanzas 
        WHERE SUBSTRING(fecha,1,4) = ?
        AND registro = "Gasto"
        AND estatus = 1 
        GROUP BY mes 
        ORDER BY mes',
        [$request->anio]);
        
        return ['meses' => $meses];
    }

    public function GastosMes(Request $request){
        if (!$request->ajax()) return redirect('/');
        $gastos = DB::select('SELECT 
        tipo,
        SUBSTRING(fecha,6,2) AS mes,
        SUM(monto) AS monto,
        COUNT(tipo) AS total 
        FROM finanzas 
        WHERE SUBSTRING(fecha,1,4) = ?
        AND SUBSTRING(fecha,6,2) = ?
        AND registro = "Gasto" 
        AND estatus = 1  
        GROUP BY tipo, mes, monto
        ORDER BY mes;',
        [$request->anio,$request->mes]);
        
        return ['gastos' => $gastos];
    }
}
