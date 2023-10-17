<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function empresa()
    {
        return view('empresa.empresa');
    }

    public function tb_empresa(Request $request)
    {
        $query = DB::table('db_empresa AS e')
                        ->select( 'e.idempresa', 'e.ruc', 'e.razon_social', 'e.resolucion', 'e.fecha_registro', 'e.fecha_inicio', 'e.fecha_fin', 'e.n_flota')
                        ->leftJoin(DB::raw('(SELECT idempresa, COUNT(*) cantidad FROM db_emp_flota GROUP BY idempresa) AS a'), 'a.idempresa', '=', 'e.idempresa')
                        ->addSelect(DB::raw('IFNULL(a.cantidad, 0) AS resultado'))
                        ->where('e.flag', 1)
                        ->get();


        return view('empresa.tablas.tb_empresa', compact('query'));
    }

    public function md_crea_empresa(Request $request)
    {
        $tipo = DB::table('db_tipo_empresa')->get();

        $subtipo = DB::table('db_subtipo_empresa')->get();

        $view = view('empresa.modals.md_crea_empresa', compact('tipo', 'subtipo'))->render();

        return response()->json(['html' => $view]);
    }

    public function subtipo_id(Request $request, $tipoid)
    {
        $subtipo = DB::table('db_subtipo_empresa')->where('idtipo_empresa', $tipoid)->get();

        $options = '<option value="">Selecciona una opción</option>';
        foreach ($subtipo as $subt) {
            $options .= '<option value="' . $subt->idsubtipo_empresa . '">' . $subt->desc_corta . ': ' . $subt->descripcion . '</option>';
        }

        return $options;
    }

    public function e_store(Request $request)
    {
        try {

            $save = new Empresa;
            $save->idsubtipo = $request->subtipo;
            $save->ruc = $request->ruc;
            $save->resolucion = $request->resolucion;
            $save->razon_social = $request->r_social;
            $save->fecha_registro = $request->f_registro;
            $save->fecha_inicio = $request->f_inicio;
            $save->fecha_fin = $request->f_fin;
            $save->n_flota = $request->cantidad_flota;
            $save->origen = $request->origen;
            $save->destino = $request->destino;
            $save->ruta = $request->ruta;

            if($request->hasFile('foto'))
            {
                $archivoIMG = $request->file('foto');
                $nombreIMG = $archivoIMG->getClientOriginalName();
                $nameruta = '/img/fotoempresa/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
                // $nameruta = $estructura_carp;  // GUARDAR EN UN SERVIDOR
                $archivoIMG->move($nameruta, $nombreIMG);

                $save->foto = $nombreIMG;
            }

            $save->flag = 1;
            $save->save();

            return $save;


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


    public function md_ver_empresa(Request $request)
    {

        $query = Empresa::select('db_empresa.*', 'a.subt_nombre', 'a.tipo_nombre')
                            ->joinSub(function ($query) {
                                $query->select('db_subtipo_empresa.idsubtipo_empresa', DB::raw("CONCAT(db_subtipo_empresa.desc_corta, ': ', db_subtipo_empresa.descripcion) as subt_nombre"), DB::raw("CONCAT(db_tipo_empresa.desc_corta, ': ', db_tipo_empresa.descripcion) as tipo_nombre"))
                                    ->from('db_subtipo_empresa')
                                    ->join('db_tipo_empresa', 'db_tipo_empresa.idtipo_empresa', '=', 'db_subtipo_empresa.idtipo_empresa');
                            }, 'a', 'a.idsubtipo_empresa', '=', 'db_empresa.idsubtipo')
                            ->where('db_empresa.idempresa', $request->id)
                            ->first();


        $view = view('empresa.modals.md_ver_empresa', compact('query'))->render();

        return response()->json(['html' => $view]);
    }

    public function md_edit_empresa(Request $request)
    {
        $query = Empresa::select('db_empresa.*', 'a.subt_nombre', 'a.tipo_nombre')
                            ->joinSub(function ($query) {
                                $query->select('db_subtipo_empresa.idsubtipo_empresa', DB::raw("CONCAT(db_subtipo_empresa.desc_corta, ': ', db_subtipo_empresa.descripcion) as subt_nombre"), DB::raw("CONCAT(db_tipo_empresa.desc_corta, ': ', db_tipo_empresa.descripcion) as tipo_nombre"))
                                    ->from('db_subtipo_empresa')
                                    ->join('db_tipo_empresa', 'db_tipo_empresa.idtipo_empresa', '=', 'db_subtipo_empresa.idtipo_empresa');
                            }, 'a', 'a.idsubtipo_empresa', '=', 'db_empresa.idsubtipo')
                            ->where('db_empresa.idempresa', $request->id)
                            ->first();

        $tipo = DB::table('db_tipo_empresa')->get();

        $subtipo = DB::table('db_subtipo_empresa')->get();

        $view = view('empresa.modals.md_edit_empresa', compact('query', 'tipo', 'subtipo'))->render();

        return response()->json(['html' => $view]);
    }

    public function e_update(request $request)
    {
        try {
            // dd($request->all());
            $save = DB::table('db_empresa')
                    ->where('idempresa', $request->id)
                    ->update([
                        'idsubtipo'=> $request->subtipo,
                        'ruc'=> $request->ruc,
                        'resolucion'=> $request->resolucion,
                        'razon_social'=> $request->r_social,
                        'fecha_registro'=> $request->f_registro,
                        'fecha_inicio'=> $request->f_inicio,
                        'fecha_fin'=> $request->f_fin,
                        'origen'=> $request->origen,
                        'destino'=> $request->destino,
                        'n_flota'=> $request->cantidad_flota,
                        'ruta'=> $request->ruta,
                    ]);

            $idempresa = $request->id;

            $foto = Empresa::findOrFail($idempresa);
            if($request->hasFile('foto'))
            {
                $archivoIMG = $request->file('foto');
                $nombreIMG = $archivoIMG->getClientOriginalName();
                $nameruta = '/img/fotoempresa/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
                // $nameruta = $estructura_carp;  // GUARDAR EN UN SERVIDOR
                $archivoIMG->move($nameruta, $nombreIMG);

                $foto->foto = $nombreIMG;
            }
            $foto->save();

            return $save;


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

    public function e_delete(Request $request)
    {
        $delete = DB::table('empresa')->where('idempresa', $request->id)->update([ 'flag' => 0 ]);

        return $delete;
    }

    public function foto_eliminar(Request $request)
    {
        $empresa = Empresa::where('idempresa', $request->id)->first();

        $ruta = 'img\\fotoempresa\\'.$empresa->foto;

        if(file_exists($ruta)){
            unlink($ruta);
        }

        $borrar_foto = DB::table('empresa')->where('idempresa', $request->id)->update([ 'foto' => NULL ]);

        return $borrar_foto;

    }
}
