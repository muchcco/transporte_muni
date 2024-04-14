<?php

namespace App\Http\Controllers\Parametros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeloController extends Controller
{
    public function index() {

        return view('parametros.modelo.index');

    }

    public function tb_index(Request $request)
    {
        $modelo = DB::table('db_vehiculo_tipo as tip')->join('db_vehiculo_subtipo as sub', 'sub.id_tipo_vehiculo', '=', 'tip.idtipo_vehiculo')
                        ->select('tip.nombre as nom_tip', 'tip.idtipo_vehiculo', 'sub.nombre as nom_subtipo', 'sub.idsubtipo_vehiculo')
                        ->get();

        return view('parametros.modelo.tablas.tb_index', compact('modelo'));
    }

    public function md_add_modelo(Request $request)
    {
        $marca = DB::table('db_vehiculo_tipo as tip')->get(); 

        $view = view('parametros.modelo.modals.md_add_modelo', compact('marca'))->render();

        return response()->json(['html' => $view]);
    }

    public function store_modelo(Request $request)
    {
        try{
            // DB::beginTransaction();

           $save = DB::table('db_vehiculo_subtipo')->insert([
                    'id_tipo_vehiculo'          =>  $request->input('marca'),
                    'nombre'                    =>  $request->input('modelo'),
           ]);

           return $save;

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

    public function md_edit_modelo(Request $request)
    {
        // dd($request->all());

        $modelo = DB::table('db_vehiculo_subtipo as sub')->where('idsubtipo_vehiculo', $request->id)->first();

        // dd($modelo);

        $marca = DB::table('db_vehiculo_tipo as tip')->where('idtipo_vehiculo', $modelo->id_tipo_vehiculo)->first();      

        // dd($modelo);

        $view = view('parametros.modelo.modals.md_edit_modelo', compact('modelo', 'marca'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_modelo(Request $request)
    {
        try{
            // DB::beginTransaction();

           $save = DB::table('db_vehiculo_subtipo')->where('idsubtipo_vehiculo', $request->id)->update([
                    'nombre' =>  $request->input('modelo'),
           ]);

           return $save;

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

    public function delete_modelo(Request $request)
    {
        try{
            // DB::beginTransaction();

           $save = DB::table('db_vehiculo_subtipo')->where('idsubtipo_vehiculo', $request->id)->delete();

           return $save;

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
}
