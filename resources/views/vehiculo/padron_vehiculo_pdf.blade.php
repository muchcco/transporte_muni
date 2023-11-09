<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> EMPADRONAMIENTO VEHICULAR </title>
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css')}}">

    <style>
        body{
            margin: 0;
            padding: 0;
        }

        header{
            margin: 0;
            padding: 0;
        }

        table, tr, th, td{
            margin-left: auto;
            margin-right: auto;
        }

        .td-mid {
            text-align:center;
            padding-top: .3em;            
        }

        .texto {
            font-size: .8em;
            padding-left: 1em;
            padding-right: 1em;
            text-align: justify;
            text-justify: inter-word;
        }
        
        .table-head , th, td {
            border: 1px solid black;
        }

        .table-bor{
            font-size: .8em;
            padding-left: 1em;
            padding-right: 1em;
        }

        .table-head{
            width: 100%;
        }

        .t-d-h {
            border: 1px solid #000;
            padding: .2em;
        }

        .footer{
            margin-top: 8em;
        }
    </style>
</head>
<body>
    <header>
        <div class=" ">
            <div class="">
                <table class="table table-bordered table-head">
                    <tr>                        
                        <th><img src="img/logo-muni-2.png" alt=""></th>
                        <th>SUB GERENCIA DE TRÁNSITO, TRANSPORTE Y SEGURIDAD <br />UNIDAD DE TRANSPORTE</th>
                    </tr>
                </table>
            </div>
        </div>
    </header>   
    <br />
    <section>
        <center><strong>EMPADRONAMIENTO DEL VEHICULAR</strong></center>
        <br />
        <p>Visto el Exp. Adm. Nº 15710-2021, de fecha 01 de SETIEMBRE de 2021 presentado por el (la) SR(a). {{ $persona->apellido_pat }} {{ $persona->apellido_mat }}, {{ $persona->nombre }}  Identificado con DNI. N° {{ $persona->dni }}, Domiciliado en {{ $persona->direccion }}; Distrito {{ $dep_persona->name_dist }}, Provincia {{ $dep_persona->name_prov }} y Departamento de {{ $dep_persona->name_dep }} , el cual solicita el Empadronamiento del Vehículo de la placa de rodaje: {{ $vehiculo->n_placa }}, para realizar el Servicio de Transporte Terrestre en {{ $vehiculo->tipologia }}, revisado los documentos adjuntos al presente, se deja Constancia de lo siguiente: 
            
            </p>
            <br />
            <table class="table table-bordered table-head">
                <tr>
                    <th>N° DE PADRON:</th>
                    <th colspan="3">{{ $vehiculo->n_padron }}</th>
                </tr>
                <tr>
                    <th>PLACA:</th>
                    <th colspan="3">{{ $vehiculo->n_placa }}</th>
                </tr>
                <tr>
                    <th>PROPIETARIO:</th>
                    <th colspan="3">{{ $persona->apellido_pat }} {{ $persona->apellido_mat }}, {{ $persona->nombre }}</th>
                </tr>
                <tr>
                    <th>DOMICILIO:</th>
                    <th colspan="3">{{ $persona->direccion }}</th>
                </tr>
                <tr>
                    <th>CAT.CLASE:</th>
                    <th>{{ $vehiculo->cat_clase }}</th>
                    <th>COMBUSTIBLE:</th>
                    <th>{{ $vehiculo->combustible }}</th>
                </tr>
                <tr>
                    <th>MARCA:</th>
                    <th>{{ isset($marca_v->name_marca) ? ' - ' : ' Actualizar '}}</th>
                    <th>AÑO DE FABRICACION:</th>
                    <th>{{ $vehiculo->año_fabricacion }}</th>
                </tr>
                <tr>
                    <th>MODELO:</th>
                    <th>{{ isset($marca_v->name_modelo) ? ' - ' : ' Actualizar '}}</th>
                    <th>ASIENTOS:</th>
                    <th>{{ $vehiculo->n_asientos }}</th>
                </tr>
                <tr>
                    <th>MOTOR:</th>
                    <th>{{ $vehiculo->motor }}</th>
                    <th>CARROCERIA:</th>
                    <th>{{ $vehiculo->carroceria }}</th>
                </tr>
            </table>
            <br />
            <p>Se expide el presente a solicitud escrita del interesado, debiendo cancelar en Caja de la Municipalidad Provincial de Huancavelica la suma de S/. 10.00 (DIEZ Y 00/  SOLES) por dicho concepto. </p>
    </section>



</body>
</html>