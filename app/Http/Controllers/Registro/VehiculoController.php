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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Archivovehiculo;

class VehiculoController extends Controller
{
    public function index()
    {
        return view('vehiculo.index');
    }

    public function tb_index(Request $request)
    {
        $data = DB::table('db_vehiculo as v')
                            ->select('v.*', 'p.*', DB::raw('IFNULL(count_emp, "0") AS afiliado'))
                            ->leftJoin('db_persona as p', 'p.idpersona', '=', 'v.idpersona')
                            ->leftJoin(DB::raw('(SELECT idflota, idpersona, idvehiculo, COUNT(*) AS count_emp FROM db_emp_flota GROUP BY idflota, idpersona, idvehiculo) as f'), 'f.idvehiculo', '=', 'v.idvehiculo')
                            ->whereNotNull('v.n_padron')
                            ->where('v.flag', 1)
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

            $vehiculo_padron = DB::table('db_vehiculo')->orderby('idvehiculo', 'DESC')->first();
            

            if(isset($vehiculo_padron->n_padron)){
                $cont_ = $vehiculo_padron->n_padron + 1;
                // dd($cont_);
                $codpadron = Str::padLeft($cont_, 8, '0');
            }else{
                $codpadron = '00000001';
            }

            $persona_id = Persona::where('dni', $request->dni)->first();
            $vehiculo = Vehiculo::where('n_placa', $request->n_placa)->first();
            // dd($persona_id);
            
            // dd("SI EXISTE UNA PERSONA");
            if(isset($persona_id)){

                if($vehiculo){
                    if( $vehiculo->idpersona == $persona_id->idpersona && $vehiculo->n_placa == $request->n_placa && $vehiculo->n_padron != NULL ){
                    
                        $response_ = response()->json([
                            'data' => null,
                            'message' => 'El vehículo ya fue registrado',
                            'status' => '210'
                        ], 200);
        
                        return $response_;
        
                    }elseif($vehiculo->idpersona != $persona_id->idpersona && $vehiculo->n_placa == $request->n_placa){
        
                        $vehi = Vehiculo::join('db_persona', 'db_persona.idpersona', '=', 'db_vehiculo.idpersona')->where('db_vehiculo.idpersona', $vehiculo->idpersona)->first();
        
                        $response_ = response()->json([
                            'data' => null,
                            'message' => "El vehículo pertence la persona " . $vehi->nombre . ' ' . $vehi->apellido_pat . ' ' .  $vehi->apellido_mat,
                            'status' => '210'
                        ], 200);
        
                        return $response_;
                    }elseif($vehiculo->flag = 0 ){
                        $save = Vehiculo::findOrFail($vehiculo->idvehiculo);
                        $save->flag = 1;
                        $save->save();

                        return $save;
                    }
                }
                // dd("sad");
                if(isset($vehiculo)){
                    // dd($persona_id);
                    $save = Vehiculo::findOrFail($vehiculo->idvehiculo);
                    $save->n_padron = $codpadron;
                    $save->flag = 1;
                    $save->save();

                    $dat = DB::table('db_vehiculo_responsable')->insert([
                        'id_vehiculo' =>    $save->idvehiculo,
                        'id_persona'  =>    $persona_id->idpersona,
                    ]);

                    return $save;

                }else{
                    
                    $save = new Vehiculo;
                    $save->idpersona = $persona_id->idpersona;
                    $save->n_placa = $request->n_placa;
                    $save->tipologia = $request->tipologia;
                    $save->n_padron = $codpadron;
                    $save->flag = 1;
                    $save->mes = Carbon::now()->format('m');
                    $save->año = Carbon::now()->format('Y');
                    $save->save();

                    $dat = DB::table('db_vehiculo_responsable')->insert([
                        'id_vehiculo' =>    $save->idvehiculo,
                        'id_persona'  =>    $persona_id->idpersona,
                    ]);

                    return $save;
                }
                
            }else{
                // dd("sad");
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

                $save = new Vehiculo;
                $save->idpersona = $persona->idpersona;
                $save->n_padron = $codpadron;
                $save->n_placa = $request->n_placa;
                $save->tipologia = $request->tipologia;
                $save->flag = 1;
                $save->mes = Carbon::now()->format('m');
                $save->año = Carbon::now()->format('Y');
                $save->save();

                $dat = DB::table('db_vehiculo_responsable')->insert([
                    'id_vehiculo' =>    $save->idvehiculo,
                    'id_persona'  =>    $persona->idpersona,
                ]);
                
                return $save;
            }            
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

    public function baja_vehiculo(Request $request)
    {
        $update = Vehiculo::findOrFail($request->idvehiculo);
        $update->flag = 0;
        $update->save();

        return $update;
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

        $tipo_dato = DB::table('db_vehiculo_tipo_dato')->where('tipo_seleccion', 1)->get();

        

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

        //dd($vehiculo);

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
        $update->tipologia = $request->tipologia;
        $update->pago_padron = $request->pago_padron;
        $update->combustible = $request->combustible;
        $update->serie = $request->serie;
        $update->color = $request->color;
        $update->año_fabricacion = $request->año_fabricacion;
        $update->n_asientos = $request->n_asientos;
        $update->motor = $request->motor;
        $update->carroceria = $request->carroceria;
        $update->n_recibo = $request->n_recibo;
        $update->fecha_recibo = $request->fecha_recibo;
        $update->monto_recibo = $request->monto_recibo;
        // dd($update);
        $update->save();

        return $update;
    }

    public function store_tip_dato(Request $request)
    {
        $validated = $request->validate([
            'idtipo_dato' => 'required',
            'fecha_exp' => 'required',
            'fecha_vence' => 'required',
            'ruta' => 'required',
        ]);


        $persona = Persona::join('db_vehiculo', 'db_vehiculo.idpersona', '=', 'db_persona.idpersona')->where('db_vehiculo.idvehiculo', $request->idvehiculo)->first();

        $estructura_carp = 'archivo\\vehiculo\\'.$persona->dni;

        if (!file_exists($estructura_carp)) {
            mkdir($estructura_carp, 0777, true);
        }

        $save = new Archivo;
        $save->idtipo_dato = $request->idtipo_dato;
        $save->idvehiculo = $request->idvehiculo;
        $save->fecha_expedicion = $request->fecha_exp;
        $save->fecha_vencimiento = $request->fecha_vence;
        if($request->hasFile('ruta'))
        {
            $archivoIMG = $request->file('ruta');
            $nombreIMG = $archivoIMG->getClientOriginalName();
            //$nameruta = '/img/fotoempresa/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
            $nameruta = $estructura_carp;  // GUARDAR EN UN SERVIDOR
            $archivoIMG->move($nameruta, $nombreIMG);

            $save->nombre_archivo = $nombreIMG;
            $save->ruta = $estructura_carp.'\\'.$nombreIMG;
        }
        $save->save();

        return $save;
    }

    public function padron_vehiculo_pdf(Request $request, $idvehiculo)
    {
        $vehiculo = Vehiculo::where('idvehiculo', $idvehiculo)->first();

        $persona = Persona::where('idpersona', $vehiculo->idpersona)->first();

        $marca_v = DB::table('db_vehiculo_tipo as t')->join('db_vehiculo_subtipo as s', 's.id_tipo_vehiculo', '=', 't.idtipo_vehiculo')
                        ->select('t.min_nombre as name_marca', 's.min_nombre as name_modelo')
                        ->where('s.idsubtipo_vehiculo', $vehiculo->idmodelo)
                        ->first();

        $dep_persona = DB::table('ubigeo_peru_districts')
                        ->join('ubigeo_peru_provinces', 'ubigeo_peru_provinces.id', '=', 'ubigeo_peru_districts.province_id')
                        ->join('ubigeo_peru_departments', 'ubigeo_peru_departments.id','=','ubigeo_peru_districts.department_id')
                        ->select('ubigeo_peru_districts.id as iddistrito', 'ubigeo_peru_districts.name as name_dist', 'ubigeo_peru_provinces.id as idprovincia', 'ubigeo_peru_provinces.name as name_prov', 'ubigeo_peru_departments.id as iddepartamento', 'ubigeo_peru_departments.name as name_dep')
                        ->where('ubigeo_peru_districts.id', $persona->iddistrito)
                        ->first();

        $pdf = Pdf::loadView('vehiculo.padron_vehiculo_pdf', compact('vehiculo', 'persona', 'marca_v', 'dep_persona'))->setPaper('a4');
        return $pdf->stream();
    }

    public function delete_tip_dato(Request $request)
    {        
        $id_archivo = Archivovehiculo::where('idvehiculo_archivo', $request->idvehiculo_archivo)->first();
        // dd($id_archivo);

        if(file_exists( $id_archivo->ruta)){
            unlink($id_archivo->ruta);
        }

        $delete = Archivovehiculo::where('idvehiculo_archivo', $request->idvehiculo_archivo)->delete();       

        return $delete;
    }
}
