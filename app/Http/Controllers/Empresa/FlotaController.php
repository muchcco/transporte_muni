<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Flota;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\Vehiculo;
use App\Models\Conductor;
use App\Models\Archivo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FlotaController extends Controller
{
    public function index(Request $request, $idempresa)
    {
        $empresa = Empresa::where('idempresa', $idempresa)->first();

        $total_flota = Flota::where('idempresa', $idempresa)->count();

        $restante = $empresa->n_flota - $total_flota;

        //creamos el porcentaje

        $porcentaje = ($total_flota / 100) * $empresa->n_flota;

        // dd($porcentaje);

        return view('empresa.flota.index', compact('empresa', 'total_flota', 'restante', 'porcentaje'));
    }

    public function tb_index(Request $request)
    {
        $flota = Flota::leftJoin('db_vehiculo as v', 'v.idvehiculo', '=', 'db_emp_flota.idvehiculo')
                                ->leftJoin(DB::raw('(SELECT CONCAT(db_persona.apellido_pat, " ", db_persona.apellido_mat, ", ", db_persona.nombre) AS nom_persona, db_persona.idpersona, db_conductor.n_brevete
                                    FROM db_conductor
                                    JOIN db_persona ON db_persona.idpersona = db_conductor.idpersona
                                ) AS c'), 'c.idpersona', '=', 'db_emp_flota.idpersona')
                                ->select('db_emp_flota.idflota', 'c.nom_persona', 'c.n_brevete', 'v.n_placa', 'v.año_fabricacion', 'db_emp_flota.tipologia', 'db_emp_flota.correlativo')
                                ->get();

        return view('empresa.flota.tablas.tb_index', compact('flota'));
    }

    public function md_crea_flota (Request $request)
    {
        $departamentos = DB::table('ubigeo_peru_departments')->get();

        $tip_licencia = DB::table('db_clase_licencia')
                        ->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                        ->select('db_categoria_licencia.idcategoria_licencia', DB::raw("CONCAT(db_clase_licencia.descripcion, ' ', db_categoria_licencia.descripcion) AS descr_licencia"))
                        ->get();

        $view = view('empresa.flota.modals.md_crea_flota', compact('tip_licencia', 'departamentos'))->render();

        return response()->json(['html' => $view]);
    }

    public function store_flota(Request $request)
    {
        $n_corr = Flota::where('idempresa', $request->idempresa)->orderBy('correlativo', 'DESC')->first();

        $conduc_padron = DB::table('db_conductor')->orderby('idconductor', 'DESC')->first();

        if(isset($conduc_padron->n_padron)){
            $cont_ = $conduc_padron->n_padron + 1;
            // dd($cont_);
            $codpadron = Str::padLeft($cont_, 5, '0');
        }else{
            $codpadron = '00001';
        }

        if($n_corr == 'NULL' || !$n_corr ){
            $correl = 1;       
        }else{            
            $correl = $n_corr->correlativo + 1;
        }

        $persona = Persona::where('dni', $request->dni)->first();

        if(isset($persona)){
            $idpersona = $persona->idpersona;

            $vehiculo = Vehiculo::where('idpersona', $persona->idpersona)->first();

            if(isset($vehiculo)){
                $idvehiculo = $vehiculo->idvehiculo;
            }else{
                // return "asda";
                $idvehiculo = NULL;
            }

        }else{
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

            $conductor = new Conductor;
            $conductor->idpersona = $persona->idpersona;
            $conductor->n_padron = $codpadron;
            $conductor->mes = Carbon::now()->format('m');
            $conductor->año = Carbon::now()->format('Y');
            $conductor->save();


            $idvehiculo = NULL;
        }

        $flota =  new Flota;
        $flota->idempresa = $request->idempresa;
        $flota->idpersona = $persona->idpersona;
        $flota->idvehiculo = $idvehiculo;
        $flota->flag = 1;
        $flota->correlativo = $correl;
        $flota->save();

        return $flota;
    }

    public function flota_vista(Request $request, $idflota)
    {

        $flota_conductor= Flota::leftJoin('db_persona', 'db_persona.idpersona', '=', 'db_emp_flota.idpersona')->where('db_emp_flota.idflota', $idflota)->first();

        $flota_empresa = Empresa::leftJoin('db_emp_flota', 'db_emp_flota.idempresa', '=', 'db_empresa.idempresa')->where('db_emp_flota.idflota', $idflota)->first();

        //  dd($flota_empresa);
        $idempresa = $flota_empresa->idempresa;

        if($flota_empresa->idpersona !== null && $flota_empresa->idvehiculo !== null){
            $conductor = Persona::leftJoin('db_conductor', 'db_conductor.idpersona', '=', 'db_persona.idpersona')->where('db_persona.idpersona', $flota_conductor->idpersona)->first();

            $tipo_licencia = DB::table('db_clase_licencia')->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                                        ->where('db_categoria_licencia.idcategoria_licencia', $conductor->idcategoria_licencia)
                                        ->select('db_categoria_licencia.descripcion')
                                        ->first();
    
            $vehiculo = Vehiculo::join('db_persona', 'db_persona.idpersona', '=', 'db_vehiculo.idpersona')->where('db_persona.idpersona', $conductor->idpersona)->first();
    
            if(isset($vehiculo)){
    
                $marca_v = DB::table('db_vehiculo_tipo as t')->join('db_vehiculo_subtipo as s', 's.id_tipo_vehiculo', '=', 't.idtipo_vehiculo')
                            ->select('t.min_nombre as name_marca', 's.min_nombre as name_modelo')
                            ->where('s.idsubtipo_vehiculo', $vehiculo->idmodelo)
                            ->first();
    
                $archivos = Archivo::join('db_vehiculo_tipo_dato','db_vehiculo_tipo_dato.idtipo_dato', '=', 'db_vehiculo_archivo.idtipo_dato')
                                    ->where('db_vehiculo_archivo.idvehiculo', $vehiculo->idvehiculo)
                                    ->get();
            }else{
                $marca_v = '';
                $archivos = NULL;
            }
        }elseif($flota_empresa->idpersona !== null){
            $conductor = Persona::leftJoin('db_conductor', 'db_conductor.idpersona', '=', 'db_persona.idpersona')->where('db_persona.idpersona', $flota_conductor->idpersona)->first();

            $tipo_licencia = DB::table('db_clase_licencia')->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                                        ->where('db_categoria_licencia.idcategoria_licencia', $conductor->idcategoria_licencia)
                                        ->select('db_categoria_licencia.descripcion')
                                        ->first();

            $vehiculo = '';
            $marca_v = '';
            $archivos = NULL;
        }else{
            $conductor = '';
            $tipo_licencia = '';
            $vehiculo = '';
            $marca_v = '';
            $archivos = NULL;
        }

       

        $tipo_dato = DB::table('db_vehiculo_tipo_dato')->get();

        return view('empresa.flota.flota_vista', compact( 'idempresa', 'flota_empresa', 'flota_conductor', 'conductor', 'vehiculo', 'tipo_licencia', 'marca_v', 'tipo_dato', 'archivos'));
    }

    public function baja_flota(Request $request)
    {
        $idflota = $request->idflota;

        $view = view('empresa.flota.modals.baja_flota', compact('idflota'))->render();

        return response()->json(['html' => $view]);
    }

    public function store_baja(Request $request)
    {
        try{

            $flota = Flota::join('db_empresa', 'db_empresa.idempresa', '=', 'db_emp_flota.idempresa')->where('db_emp_flota.idflota', $request->idflota)->first();

            $estructura_carp = 'archivo\\baja\\'.$flota->ruc.'\\'.$flota->correlativo;
            
            // dd($request->all());

            if($request->hasFile('ruta_sustento'))
            {
                $archivoIMG = $request->file('ruta_sustento');
                $nombreIMG = $archivoIMG->getClientOriginalName();
                //$nameruta = '/img/fotoempresa/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
                $nameruta = $estructura_carp;  // GUARDAR EN UN SERVIDOR
                $archivoIMG->move($nameruta, $nombreIMG);

                $nombre_archivo = $nombreIMG;

                $nombre_ruta = $estructura_carp.'\\'.$nombreIMG;
            }
            // dd($nombre_ruta);
            

            $fecha_actual = Carbon::now();

            $move = DB::select("INSERT log_baja_flota (sustento, nombre_archivo, nombre_ruta, idempresa, ruc, idflota, n_flota, idpersona, n_documento, empresa_fecha_registro, flota_fecha_registro, persona_fecha_registro, created_at)
                                    SELECT '".$request->sustento."', '".$nombre_archivo."', '".$nombre_ruta."', f.idempresa, e.ruc, f.idflota, f.correlativo, p.idpersona, p.dni, e.created_at, f.created_at, p.created_at, NOW()
                                    FROM db_emp_flota f
                                    JOIN db_empresa e ON e.idempresa = f.idempresa
                                    LEFT JOIN db_persona p ON p.idpersona = f.idpersona
                                    WHERE f.idflota = ".$request->idflota."");

            $elim_flota = Flota::where('idflota', $request->idflota)->update([
                                                                                'idvehiculo'         => NULL,
                                                                                'idpersona'           => NULL,
                                                                                'tipologia'         => NULL,
                                                                                'sustitucion'       => 2,
                                                                                'created_at'        => $fecha_actual,
                                                                            ]);

            // $mensaje = '¡Redirección exitosa!';
            // return Redirect::route('empresa.flota.index', ['idempresa' => $flota->idempresa])->with('mensaje', $mensaje);

            return $elim_flota;

        } catch (\Exception $e) {
            //Si existe algún error en la Transacción
            $response_ = response()->json([
                'data' => null,
                'error' => $e->getMessage(),
                'message' => 'BAD'
            ], 400);

            return $response_;
        }
    }


    public function add_vehiculo(Request $request)
    {
        // ASOCIAMOS Y VERIFICAMOS LA PERSONA Y EL VEHICULO QUE ESTA ASOCIADO AL MISMO

        $persona = Persona::join('db_vehiculo', 'db_vehiculo.idpersona', '=', 'db_persona.idpersona')->where('db_persona.idpersona', $request->idpersona)->where('db_vehiculo.n_placa', $request->n_placa)->first();


        $flota = Flota::findOrFail($request->idflota);
        $flota->idvehiculo = $persona->idvehiculo;
        $flota->save();
    }

    public function update_flota(Request $request)
    {        
        $conduc_padron = DB::table('db_conductor')->orderby('idconductor', 'DESC')->first();

        if(isset($conduc_padron->n_padron)){
            $cont_ = $conduc_padron->n_padron + 1;
            // dd($cont_);
            $codpadron = Str::padLeft($cont_, 5, '0');
        }else{
            $codpadron = '00001';
        }

        $persona = Persona::where('dni', $request->dni)->first();

        if(isset($persona)){
            $idpersona = $persona->idpersona;

            $vehiculo = Vehiculo::where('idpersona', $persona->idpersona)->first();

            if(isset($vehiculo)){
                $idvehiculo = $vehiculo->idvehiculo;
            }else{
                // return "asda";
                $idvehiculo = NULL;
            }

        }else{
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

            $conductor = new Conductor;
            $conductor->idpersona = $persona->idpersona;
            $conductor->n_padron = $codpadron;
            $conductor->mes = Carbon::now()->format('m');
            $conductor->año = Carbon::now()->format('Y');
            $conductor->save();


            $idvehiculo = NULL;
        }

        $flota = Flota::findOrFail($request->idflota);
        $flota->idpersona = $persona->idpersona;
        $flota->idvehiculo = $idvehiculo;
        $flota->flag = 1;
        $flota->save();

        return $flota;
    }

    
}
