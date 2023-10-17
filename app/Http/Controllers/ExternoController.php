<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flota;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;

class ExternoController extends Controller
{
    public function externo()
    {
        return view('externo');
    }

    /** VEHICULO **/
    public function vehiculo()
    {
        return view('vehiculo');
    }

    public function search_vehiculo(Request $request)
    {
        $datos_vehiculo = Vehiculo::where('n_placa', $request->n_placa)->first();

        if($datos_vehiculo == 'null' || !$datos_vehiculo)
        {
            return response()->json([
                            'data' => null,
                            'tipo_status' => 2,
                            'message' => 'LA PLACA NO HA SIDO REGISTRADO!'
                        ], 200);
        }else{
            return response()->json([
                'data' => $datos_vehiculo,
                'tipo_status' => 1,
                'message' => 'TIENE DATOS INGRESADOS!'
            ], 200);
        }
    }

    public function view_vehiculo(Request $request, $id)
    {

        $tip_licencia = DB::table('db_clase_licencia')
                                ->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                                ->select('db_categoria_licencia.idcategoria_licencia', DB::raw("CONCAT(db_clase_licencia.descripcion, ' ', db_categoria_licencia.descripcion) AS descr_licencia"));

        $data =  DB::table('db_vehiculo as v')
                        ->select('v.*', 'p.*', 'e.razon_social', 'e.origen', 'e.destino', 'e.tipologia', DB::raw('IFNULL(e.cont_emp, "0") as cont_emp'))
                        ->join('db_persona as p', 'p.idpersona', '=', 'v.idpersona')
                        ->leftJoin(DB::raw('(SELECT db_empresa.idempresa, db_emp_flota.idpersona, COUNT(*) AS cont_emp, db_empresa.razon_social, db_empresa.origen, db_empresa.destino , db_emp_flota.tipologia
                                            FROM db_empresa
                                            JOIN db_emp_flota ON db_emp_flota.idempresa = db_empresa.idempresa
                                            GROUP BY db_empresa.idempresa, db_emp_flota.idpersona, db_empresa.razon_social, db_empresa.origen, db_empresa.destino , db_emp_flota.tipologia) as e'), 'e.idpersona', '=', 'v.idpersona')
                        ->where('v.idvehiculo', $id)
                        ->first();

        $soat = DB::table('db_vehiculo_archivo')->where('idvehiculo', $id)->where('idtipo_dato', 1)->count();
        $tuc = DB::table('db_vehiculo_archivo')->where('idvehiculo', $id)->where('idtipo_dato', 2)->count();
        $r_tecnica = DB::table('db_vehiculo_archivo')->where('idvehiculo', $id)->where('idtipo_dato', 3)->count();

        return view('view_vehiculo', compact('data', 'soat', 'tuc', 'r_tecnica'));
    }

    /** CONDUCTOR **/
    public function conductor()
    {
        return view('conductor');
    }

    public function search_conductor(request $request)
    {
        $datos_persona = Persona::join('db_conductor', 'db_conductor.idpersona', '=','db_persona.idpersona')->where('db_persona.dni', $request->dni)->first();

        if(isset($datos_persona)){
            return response()->json([
                'data' => $datos_persona,
                'tipo_status' => 1,
                'message' => 'TIENE DATOS INGRESADOS!'
            ], 200);
        }else{
            return response()->json([
                'data' => null,
                'tipo_status' => 2,
                'message' => 'EL DNI NO HA SIDO REGISTRADO EN LA MUNICIPALIDAD DE HUANCAVELICA!'
            ], 200);
        }

    }

    public function view_conductor(request $request, $id)
    {
        $data = Persona::join('db_conductor', 'db_conductor.idpersona', '=','db_persona.idpersona')->where('db_persona.idpersona', $id)->first();

        $tipo_licencia =  DB::table('db_clase_licencia')->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                            ->where('db_categoria_licencia.idcategoria_licencia', $data->idcategoria_licencia)
                            ->select('db_categoria_licencia.descripcion')
                            ->first();

        // dd($data);

        return view('view_conductor', compact('data', 'tipo_licencia'));
    }

}
