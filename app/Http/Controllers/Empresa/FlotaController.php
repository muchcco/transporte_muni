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

        $porcentaje =   (100*$total_flota) / $empresa->n_flota;

        // dd($porcentaje);

        return view('empresa.flota.index', compact('empresa', 'total_flota', 'restante', 'porcentaje'));
    }

    public function tb_index(Request $request)
    {
        $flota = DB::table('db_emp_flota as mp')
                        ->select('mp.correlativo', DB::raw("CONCAT(p.apellido_pat, ' ', p.apellido_mat, ', ', p.nombre) as nombreu"), 'v.n_placa', 'v.año_fabricacion', 'mp.tipologia', 'mp.idflota')
                        ->leftJoin('db_persona as p', 'p.idpersona', '=', 'mp.idpersona')
                        ->leftJoin('db_vehiculo as v', 'v.idvehiculo', '=', 'mp.idvehiculo')
                        ->where('mp.flag', '1')
                        ->where('mp.idempresa', $request->idempresa)
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

        if($n_corr == 'NULL' || !$n_corr ){
            $correl = 1;       
        }else{            
            $correl = $n_corr->correlativo + 1;
        }

        $persona = Persona::where('dni', $request->dni)->first();

        if(!isset($persona)){
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
        }

        $flota =  new Flota;
        $flota->idempresa = $request->idempresa;
        $flota->idpersona = $persona->idpersona;
        // $flota->idvehiculo = $idvehiculo;
        $flota->flag = 1;
        $flota->correlativo = $correl;
        $flota->save();

        return $flota;
    }

    public function flota_vista(Request $request, $idflota)
    {

        $flota_persona= Flota::leftJoin('db_persona', 'db_persona.idpersona', '=', 'db_emp_flota.idpersona')->where('db_emp_flota.idflota', $idflota)->first();

        $flota_empresa = Empresa::leftJoin('db_emp_flota', 'db_emp_flota.idempresa', '=', 'db_empresa.idempresa')->where('db_emp_flota.idflota', $idflota)->first();

        $dato = Flota::join('db_archivos_tcirculacion', 'db_archivos_tcirculacion.id_flota', '=', 'db_emp_flota.idflota')->join('db_desc_tcirculacion', 'db_desc_tcirculacion.iddesc_circulacion', '=', 'db_archivos_tcirculacion.iddesc_circulacion')->where('id_flota', $idflota)->where('db_archivos_tcirculacion.flag', 1)->get();
        // dd($dato);

        $desc_datos = DB::table('db_desc_tcirculacion')->get();

        $count_archivos_dat = $dato->count();

        $ultima_fecha_dato = Flota::join('db_archivos_tcirculacion', 'db_archivos_tcirculacion.id_flota', '=', 'db_emp_flota.idflota')->join('db_desc_tcirculacion', 'db_desc_tcirculacion.iddesc_circulacion', '=', 'db_archivos_tcirculacion.iddesc_circulacion')->where('id_flota', $idflota)->where('db_archivos_tcirculacion.flag', 1)->latest('db_archivos_tcirculacion.fecha_registro')->first();

        if($ultima_fecha_dato){
            $valor_1 = $ultima_fecha_dato->fecha_registro;
            $valor_2 = $ultima_fecha_dato->fecha_caducidad;
        }else{
            $valor_1 = null;
            $valor_2 = null;
        }

        // dd($dato);
        $idempresa = $flota_empresa->idempresa;

        $persona = Persona::where('idpersona',  $flota_persona->idpersona)->first();
        

        if($flota_empresa->idpersona !== null && $flota_empresa->idvehiculo !== null){
                
            $vehiculo = Vehiculo::join('db_persona', 'db_persona.idpersona', '=', 'db_vehiculo.idpersona')->where('db_vehiculo.idvehiculo', $flota_persona->idvehiculo)->first();
            // dd($vehiculo);
    
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
                       

            $vehiculo = '';
            $marca_v = '';
            $archivos = NULL;
        }else{
            $vehiculo = '';
            $marca_v = '';
            $archivos = NULL;
        }

       

        $tipo_dato = DB::table('db_vehiculo_tipo_dato')->get();

        return view('empresa.flota.flota_vista', compact( 'idempresa', 'flota_empresa', 'flota_persona',  'vehiculo',  'marca_v', 'tipo_dato', 'archivos', 'persona', 'dato', 'desc_datos', 'count_archivos_dat', 'valor_1', 'valor_2'));
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

        if(!isset($persona)){
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
        }

        $flota = Flota::findOrFail($request->idflota);
        $flota->idpersona = $persona->idpersona;
        // $flota->idvehiculo = $idvehiculo;
        $flota->flag = 1;
        $flota->save();

        return $flota;
    }

    /***************************************************************************************************************************** */

    public function md_vehiculo(Request $request)
    {
        $persona = Persona::where('idpersona', $request->idpersona)->first();

        $tipo_v = DB::table('db_vehiculo_tipo')->get();

        $view = view('empresa.flota.modals.md_vehiculo', compact('persona', 'tipo_v'))->render();

        return response()->json(['html' => $view]);
    }

    public function btnEditVehiculo(Request $request)
    {
        $persona = Persona::where('idpersona', $request->idpersona)->first();

        $vehiculo = Vehiculo::where('idvehiculo', $request->idvehiculo)->first();

        $tipo_v = DB::table('db_vehiculo_tipo')->get();

        $tipo_select = DB::table('db_vehiculo_tipo as t')->join('db_vehiculo_subtipo as s', 's.id_tipo_vehiculo', '=', 't.idtipo_vehiculo')
                                ->select('t.idtipo_vehiculo', 't.min_nombre as name_marca', 's.min_nombre as name_modelo', 's.idsubtipo_vehiculo')
                                ->where('s.idsubtipo_vehiculo', $vehiculo->idmodelo)
                                ->first();


        $view = view('empresa.flota.modals.btnEditVehiculo', compact('persona', 'tipo_v', 'vehiculo', 'tipo_select'))->render();

        return response()->json(['html' => $view]);
    }

    public function store_vehiculo(Request $request)
    {
        try{
            // DB::beginTransaction();
            $persona_id = Persona::where('idpersona', $request->idpersona)->first();           

            // $vehiculo_padron = DB::table('db_vehiculo')->orderby('idvehiculo', 'DESC')->first();

            // if(isset($vehiculo_padron->n_padron)){
            //     $cont_ = $vehiculo_padron->n_padron + 1;
            //     // dd($cont_);
            //     $codpadron = Str::padLeft($cont_, 8, '0');
            // }else{
            //     $codpadron = '00000001';
            // }
            
            $vehiculo = Vehiculo::where('n_placa', $request->n_placa)->first();

            if(isset($vehiculo)){
                $save = Vehiculo::findOrFail($vehiculo->idvehiculo);
                $save->cat_clase = $request->categoria;
                $save->idmodelo = $request->subtipo;
                $save->n_placa = $request->n_placa;
                $save->tipologia = $request->tipologia;
                $save->pago_padron = $request->pago_padron;
                $save->combustible = $request->combustible;
                $save->serie = $request->serie;
                $save->color = $request->color;
                $save->año_fabricacion = $request->año_fabricacion;
                $save->n_asientos = $request->n_asientos;
                $save->motor = $request->motor;
                $save->carroceria = $request->carroceria;
                $save->save();
            }else{
                $save = new Vehiculo;
                $save->idpersona = $request->idpersona;
                $save->cat_clase = $request->categoria;
                $save->idmodelo = $request->subtipo;
                $save->n_placa = $request->n_placa;
                $save->tipologia = $request->tipologia;
                $save->pago_padron = $request->pago_padron;
                $save->combustible = $request->combustible;
                $save->serie = $request->serie;
                $save->color = $request->color;
                $save->año_fabricacion = $request->año_fabricacion;
                $save->n_asientos = $request->n_asientos;
                $save->motor = $request->motor;
                $save->carroceria = $request->carroceria;
                $save->mes = Carbon::now()->format('m');
                $save->año = Carbon::now()->format('Y');
                $save->save();

                $dat = DB::table('db_vehiculo_responsable')->insert([
                            'id_vehiculo' =>    $save->idvehiculo,
                            'id_persona'  =>    $request->idpersona,
                ]);
            }

            

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

    public  function update_vehiculo(Request $request)
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

    public function md_tcirculacion(Request $request)
    {
        $flota = Flota::where('idflota', $request->idflota)->first();

        $dato = Flota::leftJoin('db_archivos_tcirculacion', 'db_archivos_tcirculacion.id_flota', '=', 'db_emp_flota.idflota')->get();

        $view = view('empresa.flota.modals.md_tcirculacion', compact('flota', 'dato'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_tcirculacion(Request $request)
    {
        // dd($request->all());

        $flota = Flota::join('db_empresa', 'db_empresa.idempresa', '=', 'db_emp_flota.idempresa')->where('db_emp_flota.idflota', $request->idflota)->first();
        
        // dd($flota);

        $estructura_carp = 'archivo\\empresa\\tarjeta_circulacion\\'.$flota->ruc.'\\'.$flota->correlativo;
        
        // dd($request->all());

        if($request->hasFile('ruta'))
        {
            $archivoIMG = $request->file('ruta');
            $nombreIMG = $archivoIMG->getClientOriginalName();
            //$nameruta = '/img/fotoempresa/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
            $nameruta = $estructura_carp;  // GUARDAR EN UN SERVIDOR
            $archivoIMG->move($nameruta, $nombreIMG);

            $nombre_archivo = $nombreIMG;

            $nombre_ruta = $estructura_carp.'\\'.$nombreIMG;
        }
        // dd($nombre_ruta);

        // Obtén la fecha actual
        $fechaActual = Carbon::now();

        // Aumenta un año a la fecha actual
        $nuevaFecha = $fechaActual->addYear();

        // Formatear la nueva fecha
        $nuevaFechaFormateada = $nuevaFecha->format('Y-m-d');

        $move = DB::table('db_archivos_tcirculacion')->insert([
                                                                'id_flota'              =>      $request['idflota'],
                                                                'fecha_registro'        =>      Carbon::now()->format('Y-m-d'),
                                                                'fecha_caducidad'       =>      $nuevaFechaFormateada,
                                                                'iddesc_circulacion'    =>      $request['iddesc_circulacion'],
                                                                'nombre_archivo'        =>      $nombre_archivo,
                                                                'ruta_archivo'          =>      $nombre_ruta,
                                                                'flag'                  =>      1,
                                                            ]);

        return $move;

    }

    public function delete_tip_dato(Request $request)
    {
        $delete = DB::table('db_archivos_tcirculacion')->where('idarchivo_circulacion', $request->idarchivo_circulacion)->delete();

        return $delete;
    }
    
}
