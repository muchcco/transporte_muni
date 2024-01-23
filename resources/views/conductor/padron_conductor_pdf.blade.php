<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> EMPADRONAMIENTO DE {{ $persona->apellido_pat }} {{ $persona->apellido_mat }}, {{ $persona->nombre }} </title>
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
        <center><strong>EMPADRONAMIENTO DEL CONDUCTOR</strong></center>
        <br />
        <P>Visto el Exp. Adm. Nº {{ $conductor->expediente_doc }}, de fecha <?php setlocale(LC_TIME, 'es_PE', 'Spanish_Spain', 'Spanish'); echo strftime('%d de %B del %Y',strtotime($conductor->fecha_registro));  ?> presentado por el (la) SR(a).  {{ $persona->apellido_pat }} {{ $persona->apellido_mat }}, {{ $persona->nombre }} Identificado con DNI. N° {{ $persona->dni }}, Domiciliado en {{ $persona->direccion }}; Distrito {{ $dep_persona->name_dist }}, Provincia {{ $dep_persona->name_prov }} y Departamento de {{ $dep_persona->name_dep }}, el cual solicita el EMPADRONAMIENTO DE CONDUCTOR, revisado los documentos adjuntos al presente se deja Constancia de lo siguiente:	</P>
            <br />
            <table class="table table-bordered table-head">
                <tr>
                    <th>N° DE PADRON:</th>
                    <th colspan="3">{{ $conductor->n_padron }}</th>
                </tr>
                <tr>
                    <th>CONDUCTOR:</th>
                    <th>{{ $persona->apellido_pat }} {{ $persona->apellido_mat }}, {{ $persona->nombre }}</th>
                    <th>Nº DNI</th>
                    <th>{{ $persona->dni }}</th>
                </tr>
                <tr>
                    <th>DIRECCIÓN SEGÚN DNI:</th>
                    <th>{{ $persona->direccion }}</th>
                    <th>Nº DE LICENCIA DE CONDUCIR:</th>
                    <th>{{ $conductor->n_brevete }}</th>
                </tr>
                <tr>
                    <th>DIRECCION DE REFERENCIA::</th>
                    <th>{{ $persona->ref_direccion }}</th>
                    <th>CLASE DE LICENCIA CONDUCIR::</th>
                    <th>{{ $tipo_licencia->descripcion }}</th>
                </tr>
                <tr>
                    <th>Nº DE CELULAR:</th>
                    <th colspan="3">{{ $persona->celular }}</th>
                </tr>
            </table>
            <br />
            <p>Se expide el presente a solicitud escrita del interesado, debiendo cancelar en Caja de la Municipalidad Provincial de Huancavelica la suma de S/. {{ $conductor->monto_recibo }} (DIEZ Y 00/  SOLES) por dicho concepto. </p>
    </section>



</body>
</html>