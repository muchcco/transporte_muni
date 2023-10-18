<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\Conductor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Vehiculo;
use App\Models\Archivo;
use App\Models\Archivoconductor;
use Barryvdh\DomPDF\Facade\Pdf;

class ConductorController extends Controller
{
    public function index()
    {
        return view('conductor.index');
    }

    public function tb_index(Request $request)
    {
        $tip_licencia = DB::table('db_clase_licencia')
                                ->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                                ->select('db_categoria_licencia.idcategoria_licencia', DB::raw("CONCAT(db_clase_licencia.descripcion, ' ', db_categoria_licencia.descripcion) AS descr_licencia"));

        $data = DB::table('db_conductor as c')
                        ->join('db_persona as p', 'p.idpersona', '=', 'c.idpersona')
                        ->leftJoin(DB::raw('(SELECT db_vehiculo.idvehiculo, db_vehiculo.idpersona, COUNT(*) AS vehiculos_count
                            FROM db_vehiculo
                            JOIN db_persona ON db_persona.idpersona = db_vehiculo.idpersona
                            GROUP BY db_vehiculo.idvehiculo, db_vehiculo.idpersona) AS v'), 'v.idpersona', '=', 'c.idpersona')
                        ->leftJoin(DB::raw('(SELECT idflota, idpersona, COUNT(*) AS count_emp
                            FROM db_emp_flota
                            GROUP BY idflota, idpersona) AS f'), 'f.idpersona', '=', 'c.idpersona')
                        ->leftJoinSub($tip_licencia, 'h', function($join) {
                                $join->on('h.idcategoria_licencia', '=', 'c.idcategoria_licencia');
                            })
                        ->select('c.*', 'p.*', DB::raw('IFNULL(v.vehiculos_count, 0) AS vehiculos_count'), DB::raw('IFNULL(f.count_emp, 0) AS count_emp'), 'h.descr_licencia')
                        ->get();
                            //dd($data);

        return view('conductor.tablas.tb_index', compact('data'));
    }

    public function md_crea_conductor(Request $request)
    {
        $departamentos = DB::table('ubigeo_peru_departments')->get();

        $tip_licencia = DB::table('db_clase_licencia')
                        ->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                        ->select('db_categoria_licencia.idcategoria_licencia', DB::raw("CONCAT(db_clase_licencia.descripcion, ' ', db_categoria_licencia.descripcion) AS descr_licencia"))
                        ->get();

        $view = view('conductor.modals.md_crea_conductor', compact('tip_licencia', 'departamentos'))->render();

        return response()->json(['html' => $view]);
    }

    public function store_conductor(Request $request)
    {
        try{
            // DB::beginTransaction();

            $search = Persona::where('dni', $request->dni)->first();

            $conductor = Conductor::where('idpersona', $search->idpersona)->first();

            // dd($conductor);

            if($conductor == NULL){
                if($search != NULL){

                    $conduc_padron = DB::table('db_conductor')->orderby('idconductor', 'DESC')->first();
    
                    if(isset($conduc_padron->n_padron)){
                        $cont_ = $conduc_padron->n_padron + 1;
                        // dd($cont_);
                        $codpadron = Str::padLeft($cont_, 8, '0');
                    }else{
                        $codpadron = '00000001';
                    }
    
    
                    $save = new Conductor;
                    $save->idpersona = $search->idpersona;
                    $save->n_padron = $codpadron;
                    $save->mes = Carbon::now()->format('m');
                    $save->año = Carbon::now()->format('Y');
                    $save->save();
    
                    return $save;
    
    
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

                    dd($persona);
                    
                    $conduc_padron = DB::table('db_conductor')->orderby('idconductor', 'DESC')->first();
    
                    if(isset($conduc_padron->n_padron)){
                        $cont_ = $conduc_padron->n_padron + 1;
                        // dd($cont_);
                        $codpadron = Str::padLeft($cont_, 8, '0');
                    }else{
                        $codpadron = '00000001';
                    }
    
    
                    $save = new Conductor;
                    $save->idpersona = $persona->idpersona;
                    $save->n_padron = $codpadron;
                    $save->mes = Carbon::now()->format('m');
                    $save->año = Carbon::now()->format('Y');
                    $save->save();
    
                    return $save;
    
                    // DB::commit();
                }           
            }else{
                $response_ = response()->json([
                    'data' => null,
                    'error' => "El CONDUCTOR ya fue registrado",
                    'message' => 'BAD'
                ], 200);

                return $response_;
            }

             
    

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

    public function reg_completo(Request $request, $idconductor)
    {

        $conductor = Conductor::join('db_persona', 'db_persona.idpersona', '=', 'db_conductor.idpersona')->where('db_conductor.idconductor', $idconductor)->first();

        $tipo_licencia = DB::table('db_clase_licencia')->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                                    ->where('db_categoria_licencia.idcategoria_licencia', $conductor->idcategoria_licencia)
                                    ->select('db_categoria_licencia.descripcion')
                                    ->first();

        $archivos = Archivoconductor::join('db_vehiculo_tipo_dato','db_vehiculo_tipo_dato.idtipo_dato', '=', 'db_conductor_archivo.idtipo_dato')
                                    ->where('db_conductor_archivo.idconductor', $conductor->idconductor)
                                    ->get();

        $tipo_dato = DB::table('db_vehiculo_tipo_dato')->where('tipo_seleccion', 2)->get();

        return view('conductor.reg_completo', compact('conductor',  'tipo_licencia', 'tipo_dato', 'archivos'));
    }

    public function md_edit_persona(Request $request)
    {
        $conductor = Persona::leftJoin('db_conductor', 'db_conductor.idpersona', '=', 'db_persona.idpersona')->where('db_persona.idpersona', $request->idconductor)->first();

        // dd($request->idconductor);

        $dep_persona = DB::table('ubigeo_peru_districts')
                            ->join('ubigeo_peru_provinces', 'ubigeo_peru_provinces.id', '=', 'ubigeo_peru_districts.province_id')
                            ->join('ubigeo_peru_departments', 'ubigeo_peru_departments.id','=','ubigeo_peru_districts.department_id')
                            ->select('ubigeo_peru_districts.id as iddistrito', 'ubigeo_peru_districts.name as name_dist', 'ubigeo_peru_provinces.id as idprovincia', 'ubigeo_peru_provinces.name as name_prov', 'ubigeo_peru_departments.id as iddepartamento', 'ubigeo_peru_departments.name as name_dep')
                            ->where('ubigeo_peru_districts.id', $conductor->iddistrito)
                            ->first();

        // dd($departamentos);

        $departamentos = DB::table('ubigeo_peru_departments')->get();
        $view = view('conductor.modals.md_edit_persona', compact('conductor', 'departamentos', 'dep_persona'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_conductor(Request $request)
    {
        $idpersona = $request->idpersona;

        $persona = Persona::findOrFail($idpersona);
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

        return $persona;
    }

    public function md_edit_conductor(Request $request)
    {
        $conductor = Conductor::join('db_persona', 'db_persona.idpersona', '=', 'db_conductor.idpersona')->where('db_conductor.idconductor', $request->idconductor)->first();

        $tip_licencia = DB::table('db_clase_licencia')
                            ->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia','=','db_clase_licencia.idclase_licencia')
                            ->get();

        $view = view('conductor.modals.md_edit_conductor', compact('conductor', 'tip_licencia'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_conductor_princ(Request $request)
    {
        $update = Conductor::findOrFail($request->idconductor);
        $update->idcategoria_licencia = $request->idcategoria_licencia;
        $update->pago_padron = $request->pago_padron;
        $update->n_brevete = $request->n_brevete;
        $update->fecha_expedicion_brevete = $request->fecha_expedicion_brevete;
        $update->fecha_vencimiento_brevete = $request->fecha_vencimiento_brevete;
        $update->save();
        

        return $update;
    }

    public function md_vehiculo(Request $request)
    {
        $persona = Persona::where('idpersona', $request->idpersona)->first();

        $tipo_v = DB::table('db_vehiculo_tipo')->get();

        $view = view('conductor.modals.md_vehiculo', compact('persona', 'tipo_v'))->render();

        return response()->json(['html' => $view]);
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


        $view = view('conductor.modals.md_vehiculo_edit', compact('persona', 'tipo_v', 'vehiculo', 'tipo_select'))->render();

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

    public function store_tip_dato(Request $request)
    {
        $validated = $request->validate([
            'idtipo_dato' => 'required',
            'fecha_exp' => 'required',
            'fecha_vence' => 'required',
            'ruta' => 'required',
        ]);


        $persona = Persona::join('db_conductor', 'db_conductor.idpersona', '=', 'db_persona.idpersona')->where('db_conductor.idconductor', $request->idconductor)->first();

        $estructura_carp = 'archivo\\conductor\\'.$persona->dni;

        if (!file_exists($estructura_carp)) {
            mkdir($estructura_carp, 0777, true);
        }

        $save = new Archivoconductor;
        $save->idtipo_dato = $request->idtipo_dato;
        $save->idconductor = $request->idconductor;
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

    public function delete_tip_dato(Request $request)
    {
        $delete = Archivoconductor::where('idconductor_archivo', $request->idconductor_archivo)->delete();

        return $delete;
    }

    public function padron_conductor_pdf(Request $request, $idconductor)
    {
        $conductor =  Conductor::where('idconductor', $idconductor)->first();

        $persona = Persona::where('idpersona', $conductor->idpersona)->first();

        $tipo_licencia = DB::table('db_clase_licencia')->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
                        ->where('db_categoria_licencia.idcategoria_licencia', $conductor->idcategoria_licencia)
                        ->select('db_categoria_licencia.descripcion')
                        ->first();

        $dep_persona = DB::table('ubigeo_peru_districts')
                        ->join('ubigeo_peru_provinces', 'ubigeo_peru_provinces.id', '=', 'ubigeo_peru_districts.province_id')
                        ->join('ubigeo_peru_departments', 'ubigeo_peru_departments.id','=','ubigeo_peru_districts.department_id')
                        ->select('ubigeo_peru_districts.id as iddistrito', 'ubigeo_peru_districts.name as name_dist', 'ubigeo_peru_provinces.id as idprovincia', 'ubigeo_peru_provinces.name as name_prov', 'ubigeo_peru_departments.id as iddepartamento', 'ubigeo_peru_departments.name as name_dep')
                        ->where('ubigeo_peru_districts.id', $persona->iddistrito)
                        ->first();

        $pdf = Pdf::loadView('conductor.padron_conductor_pdf', compact('conductor', 'persona', 'dep_persona', 'tipo_licencia'))->setPaper('a4');
        return $pdf->stream();
    }
}
