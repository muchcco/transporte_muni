<?php

namespace App\Http\Controllers\Parametros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    public function index() {

        return view('parametros.marca.index');

    }

    public function tb_index(Request $request)
    {
        $marca = DB::table('db_vehiculo_tipo as tip')->get();

        return view('parametros.marca.tablas.tb_index', compact('marca'));
    }

    public function md_add_marca(Request $request)
    {


        $view = view('parametros.marca.modals.md_add_marca')->render();

        return response()->json(['html' => $view]);
    }

    public function store_marca(Request $request)
    {
        try{
            // DB::beginTransaction();

           $save = DB::table('db_vehiculo_tipo')->insert([
                    'nombre'          =>  $request->input('name'),
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

    public function md_edit_marca(Request $request)
    {
        $marca = DB::table('db_vehiculo_tipo as tip')->where('idtipo_vehiculo', $request->id)->first();

        // dd($marca);

        $view = view('parametros.marca.modals.md_edit_marca', compact('marca'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_marca(Request $request)
    {
        try{
            // DB::beginTransaction();

           $save = DB::table('db_vehiculo_tipo')->where('idtipo_vehiculo', $request->id)->update([
                    'nombre' =>  $request->input('name'),
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

    public function delete_marca(Request $request)
    {
        try{
            // DB::beginTransaction();

           $save = DB::table('db_vehiculo_tipo')->where('idtipo_vehiculo', $request->id)->delete();

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
