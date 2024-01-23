<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use App\Models\Vehiculo;

class RecursosController extends Controller
{
    public function buscar_ruc(Request $request)
    {
        $token = '';

        $number = $request->ruc;

        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
        
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $number]
        ];
        // Para usar la versión 1 de la api, cambiar a /v1/ruc
        $res = $client->request('GET', '/v1/ruc', $parameters);
        $response = json_decode($res->getBody()->getContents(), true);
        // var_dump($response);

        return $response;
    }

    public function buscar_dni(Request $request)
    {
        $datos = Persona::where('dni', $request->dni)->first();

        if($datos == 'null' || !$datos){
            $token = '';
            $numero = $request->dni;
            $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
            $parameters = [
                'http_errors' => false,
                'connect_timeout' => 5,
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Referer' => 'https://apis.net.pe/api-consulta-dni',
                    'User-Agent' => 'laravel/guzzle',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $numero]
            ];
            // Para usar la versión 1 de la api, cambiar a /v1/dni
            $res = $client->request('GET', '/v1/dni', $parameters);
            $response = json_decode($res->getBody()->getContents(), true);
            // dd($response);
            $status_code = $res->getStatusCode();
            
            // dd($status_code);

            if ($status_code === 422) {
                // El código de estado es 200 (OK)
                $response_ = response()->json([
                    'data' => $response,
                    'message' => 'BAD',
                    'status' => 100
                ], 200);
    
                return $response_;
            } else {
                if ($response !== null && isset($response['nombres'])) {
                    $dato = [];
                    $dato['nombre'] = $response['nombres'];
                    $dato['apellido_pat'] = $response['apellidoPaterno'];
                    $dato['apellido_mat'] = $response['apellidoMaterno'];
                } else {
                    // Maneja el caso en el que $response es nulo o 'nombres' no está presente
                    $response_ = response()->json([
                        'data' => null,
                        'error' => "No se encontro el DNI",
                        'message' => 'BAD',
                        'status' => 110
                    ], 200);
        
                    return $response_;
                }
                // El código de estado no es 200
                // dd($response);
                $dato = [];
                $dato['nombre'] = $response['nombres'];
                $dato['apellido_pat'] = $response['apellidoPaterno'];
                $dato['apellido_mat'] = $response['apellidoMaterno'];
                
                // dd($response['nombres']);

                
                $response_ = response()->json([
                    'data' => $dato,
                    'message' => 'BAD',
                    'status' => 130
                ], 200);
    
                return $response_;
            }
            
                     
            
        }elseif(isset($datos)){

            $distritos = DB::table('ubigeo_peru_districts')->where('id', $datos->iddistrito)->first();

            // dd($distritos);

            $provincias = DB::table('ubigeo_peru_provinces')->where('id', $distritos->province_id)->first();

            $departamento = DB::table('ubigeo_peru_departments')->where('id', $distritos->department_id)->first();

            $response_ = response()->json([
                'data' => $datos,
                'distrito' => $distritos,
                'departamento' => $departamento,
                'provincia' => $provincias,
                'error' => "El Conductor ya fue registrado",
                'message' => 'BAD',
                'status' => 120,
            ], 200);
            return $response_;
        }
        return $datos;
        // var_dump($response);
        
    }

    public function buscar_placa(Request $request)
    {
        $placa = Vehiculo::where('n_placa', $request->n_placa)->first();

        if($placa){

            $subtipo = DB::table('db_vehiculo_subtipo')->where('idsubtipo_vehiculo', $placa->idmodelo)->first();

            $tipo = DB::table('db_vehiculo_tipo')->where('idtipo_vehiculo', $subtipo->id_tipo_vehiculo)->first();

            $response_ = response()->json([
                'data' => $placa,
                'subtipo' => $subtipo,
                'tipo' => $tipo,
                'message' => 'BAD',
                'status' => 100
            ], 200);
        }else{
            $response_ = response()->json([
                'data' => 'El vehiculo no fue registrado',
                'message' => 'BAD',
                'status' => 101
            ], 200);
        }

        return $response_;
    }

    public function provincias($departamento_id)
    {
        $provincias = DB::table('ubigeo_peru_provinces')->where('department_id', $departamento_id)->get();

        $options = '<option value="">Selecciona una opción</option>';
        foreach ($provincias as $prov) {
            $options .= '<option value="' . $prov->id . '">' . $prov->name . '</option>';
        }

        return $options;
    }

    public function distritos($provincia_id)
    {        
        $distritos = DB::table('ubigeo_peru_districts')->where('province_id', $provincia_id)->get();

        $options = '<option value="">Selecciona una opción</option>';
        foreach ($distritos as $dist) {
            $options .= '<option value="' . $dist->id . '">' . $dist->name . '</option>';
        }

        return $options;
    }

    public function subtipo_vehiculo($idsubtipo_vehiculo)
    {        
        $subtipo = DB::table('db_vehiculo_subtipo')->where('id_tipo_vehiculo', $idsubtipo_vehiculo)->get();

        $options = '<option value="">Selecciona una opción</option>';
        foreach ($subtipo as $sub) {
            $options .= '<option value="' . $sub->idsubtipo_vehiculo . '">' . $sub->min_nombre . '</option>';
        }

        return $options;
    }
}
