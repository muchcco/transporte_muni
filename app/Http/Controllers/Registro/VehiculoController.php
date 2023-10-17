<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vehiculo;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Archivo;

class VehiculoController extends Controller
{
    public function index()
    {
        return view('vehiculo.index');
    }

    public function tb_index(Request $request)
    {
        $data = DB::table('db_vehiculo as v')
                        ->select('v.*', 'p.*', DB::raw('IFNULL(count_emp, "0") as afiliado'))
                        ->join('db_persona as p', 'p.idpersona', '=', 'v.idpersona')
                        ->leftJoin(DB::raw('(SELECT idflota, idpersona, COUNT(*) AS count_emp
                            FROM db_emp_flota
                            GROUP BY idflota, idpersona) as f'), 'f.idpersona', '=', 'v.idpersona')
                        ->get();
                            //dd($data);

        return view('vehiculo.tablas.tb_index', compact('data'));
    }

    public function md_crea_vehiculo(Request $request)
    {
        $departamentos = DB::table('ubigeo_peru_departments')->get();

        $view = view('vehiculo.modals.md_crea_vehiculo', compact('departamentos'))->render();

        return response()->json(['html' => $view]);
    }

    public function store_vehiculo(Request $request)
    {
        try{
            // DB::beginTransaction();

            $validated = $request->validate([
                'dni' => 'required',
                'nombre' => 'required',
                'ape_pat' => 'required',
                'ape_mat' => 'required',
            ]);

            $persona_id = Persona::where('dni', $request->dni)->first();           

            if(isset($persona_id)){
                $persona_id_p = $persona_id->idpersona;
            } else{
                $persona = new Persona;
                $persona->dni = $request->dni;
                $persona->nombre = $request->nombre;
                $persona->apellido_pat = $request->ape_pat;
                $persona->apellido_mat = $request->ape_mat;
                $persona->sexo = $request->sexo;
                $persona->direccion = $request->direccion;
                $persona->tipo_documento = $request->tipo_documento;
                $persona->correo = $request->correo;
                $persona->iddistrito = $request->distrito;
                $persona->celular = $request->celular;
                $persona->ref_direccion = $request->dir_referencia;
                $persona->save(); 

                $persona_id_p = $persona->idpersona;
            }

            $vehiculo_padron = DB::table('db_vehiculo')->orderby('idvehiculo', 'DESC')->first();

            if(isset($vehiculo_padron->n_padron)){
                $cont_ = $vehiculo_padron->n_padron + 1;
                // dd($cont_);
                $codpadron = Str::padLeft($cont_, 8, '0');
            }else{
                $codpadron = '00000001';
            }
            
            $save = new Vehiculo;
            $save->idpersona = $persona_id_p;
            $save->n_padron = $codpadron;
            $save->mes = Carbon::now()->format('m');
            $save->año = Carbon::now()->format('Y');
            $save->save();

            $dat = DB::table('db_vehiculo_responsable')->insert([
                                                                'id_vehiculo' =>    $save->idvehiculo,
                                                                'id_persona'  =>    $persona_id_p,
                                                            ]);

            return $save;
            
            // DB::commit();
    

        }catch (\Exception $e) {
           // DB::rollback(); //Anular los cambios en la DB
            //Si existe algún error en la Transacción
            $response_ = response()->json([
                'data' => null,
                'error' => $e->getMessage(),
                'message' => 'BAD'
            ], 400);

            return $response_;
        }
    }

    public function reg_completo(Request $request, $idvehiculo)
    {
        $vehiculo = Vehiculo::where('idvehiculo', $idvehiculo)->first();

        $persona = Persona::where('idpersona', $vehiculo->idpersona)->first();

        $marca_v = DB::table('db_vehiculo_tipo as t')->join('db_vehiculo_subtipo as s', 's.id_tipo_vehiculo', '=', 't.idtipo_vehiculo')
                        ->select('t.min_nombre as name_marca', 's.min_nombre as name_modelo')
                        ->where('s.idsubtipo_vehiculo', $vehiculo->idmodelo)
                        ->first();

        $archivos = Archivo::join('db_vehiculo_tipo_dato','db_vehiculo_tipo_dato.idtipo_dato', '=', 'db_vehiculo_archivo.idtipo_dato')
                            ->where('db_vehiculo_archivo.idvehiculo', $vehiculo->idvehiculo)
                            ->get();

        $tipo_dato = DB::table('db_vehiculo_tipo_dato')->get();

        

        // dd($vehiculo);
        return view('vehiculo.reg_completo', compact('persona', 'vehiculo', 'marca_v', 'tipo_dato', 'archivos'));
    }

    public function md_vehiculo_edit(Request $request)
    {
        $persona = Persona::where('idpersona', $request->idpersona)->first();

        $vehiculo = Vehiculo::where('idvehiculo', $request->idvehiculo)->first();

        $tipo_v = DB::table('db_vehiculo_tipo')->get();

        $tipo_select = DB::table('db_vehiculo_tipo as t')->join('db_vehiculo_subtipo as s', 's.id_tipo_vehiculo', '=', 't.idtipo_vehiculo')
                                ->select('t.idtipo_vehiculo', 't.min_nombre as name_marca', 's.min_nombre as name_modelo', 's.idsubtipo_vehiculo')
                                ->where('s.idsubtipo_vehiculo', $vehiculo->idmodelo)
                                ->first();

        // dd($tipo_select);

        $view = view('vehiculo.modals.md_vehiculo_edit', compact('persona', 'tipo_v', 'vehiculo', 'tipo_select'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_vehiculo(Request $request)
    {
        $idvehiculo = $request->idvehiculo;

        $update = Vehiculo::findOrFail($idvehiculo);
        $update->cat_clase = $request->categoria;
        $update->idmodelo = $request->subtipo;
        $update->n_placa = $request->n_placa;
        $update->combustible = $request->combustible;
        $update->serie = $request->serie;
        $update->color = $request->color;
        $update->año_fabricacion = $request->año_fabricacion;
        $update->n_asientos = $request->n_asientos;
        $update->motor = $request->motor;
        $update->carroceria = $request->carroceria;
        $update->save();

        return $update;
    }
}
