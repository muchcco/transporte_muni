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
use Illuminate\Support\Facades\File;

class ConductorController extends Controller
{
    public function index()
    {
        return view('conductor.index');
    }

    public function tb_index(Request $request)
    {
        // $tip_licencia = DB::table('db_clase_licencia')
        //                         ->join('db_categoria_licencia', 'db_categoria_licencia.idclase_licencia', '=', 'db_clase_licencia.idclase_licencia')
        //                         ->select('db_categoria_licencia.idcategoria_licencia', DB::raw("CONCAT(db_clase_licencia.descripcion, ' ', db_categoria_licencia.descripcion) AS descr_licencia"));

        $data =  Conductor::select('db_conductor.n_padron', 'db_persona.nombre', 'db_persona.apellido_pat', 'db_persona.apellido_mat', 'db_persona.dni', 'db_categoria_licencia.desc_corta', 'db_conductor.n_brevete', 'db_conductor.idconductor')
                    ->leftJoin('db_persona', 'db_persona.idpersona', '=', 'db_conductor.idpersona')
                    ->leftJoin('db_categoria_licencia', 'db_categoria_licencia.idcategoria_licencia', '=', 'db_conductor.idcategoria_licencia')
                    ->where('db_conductor.flag', '1')
                    ->get();
    

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

            if(!isset($search)){
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

                // dd($persona);
                
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
            }else{
                $conductor = Conductor::where('idpersona', $search->idpersona)->first();
            }            

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

    public function delete_conductor(Request $request)
    {
        $id_archivo = Archivoconductor::where('idconductor', $request->idconductor)->get();

        foreach ($id_archivo as $archivo) {
            
            if(file_exists( $archivo->ruta)){
                $del = unlink($archivo->ruta);

                // dd($del);q
            }else{
                // dd('no paso');
            }

        }

        $delete = Archivoconductor::where('idconductor', $request->idvehiculo_archivo)->delete();

        $del_conductor = Conductor::where('idconductor', $request->idconductor)->delete();

        return $del_conductor;
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
        $estructura_carp = 'img\\fotoconductor\\';           

        if (!file_exists($estructura_carp)) {
            mkdir($estructura_carp, 0777, true);
        }


        // dd($request->all());
        $update = Conductor::findOrFail($request->idconductor);
        $update->idcategoria_licencia = $request->idcategoria_licencia;
        $update->pago_padron = $request->pago_padron;
        $update->n_brevete = $request->n_brevete;
        $update->n_recibo = $request->n_recibo;
        $update->fecha_recibo = $request->fecha_recibo;
        $update->monto_recibo = $request->monto_recibo;
        $update->expediente_doc = $request->n_expediente;
        $update->fecha_registro = $request->fecha_expediente;
        $update->fecha_expedicion_brevete = $request->fecha_expedicion_brevete;
        $update->fecha_vencimiento_brevete = $request->fecha_vencimiento_brevete;
        if($request->hasFile('foto_conductor'))
        {
            $foto_conductor = $request->file('foto_conductor');
            $nombreFOTO = $foto_conductor->getClientOriginalName();
            // $nameruta = '/img/fotoconductor/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
            $nameruta = $estructura_carp;  // GUARDAR EN UN SERVIDOR
            $foto_conductor->move($nameruta, $nombreFOTO);

            $update->foto_conductor = $nombreFOTO;
        }
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
        $id_archivo = Archivoconductor::where('idconductor_archivo', $request->idvehiculo_archivo)->first();

        if(file_exists( $id_archivo->ruta)){
            unlink($id_archivo->ruta);
        }

        $delete = Archivoconductor::where('idconductor_archivo', $request->idvehiculo_archivo)->delete();       

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

    public function añadir_foto(Request $request)
    {
        $update = Conductor::findOrFail($request->idconductor);
        if($request->hasFile('foto_conductor'))
        {
            $foto_conductor = $request->file('foto_conductor');
            $nombreFOTO = $foto_conductor->getClientOriginalName();
            $nameruta = '/img/fotoconductor/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
            // $namerutaDNI = $estructura_carp;  // GUARDAR EN UN SERVIDOR
            $foto_conductor->move($nameruta, $nombreFOTO);

            $update->foto_conductor = $foto_conductor.'\\'.$foto_conductor;
        }
        $update->save();

        return $update;
    }
}
