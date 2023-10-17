<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Constatación Vehicular</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <style>
        body{
            /* background-color: #cacaca; */
        }

        .container{
            background-color: #fff;
        }

        .cuerpo{
            vertical-align: middle !important;
            height:100vh ;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .title-c{
            padding-top: 2em;
            background-color: #cf2e2e;
            color: #fff;
        }

        /* .body-c{height: 200px;} */

        .cuadros{

            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            
            height: 100%;
        }

        .cuadro-cont{
            padding: 2.8em;
            color: #fff;
            text-decoration: none;
        }

        .cuadro-cont:hover{
            
            opacity: 0.9;
        }

    </style>

</head>
<body>

<section class="container">

    <section class="cuerpo">
        <div class="title-c">
            <h1><center>Verificación de Vehiculos y Conductores</center></h1>
        </div>
        <div class="body-c mt-2">
            @yield('main')
        </div>
        <div class="footer-c">
            <p><center>Derechos Reservados - Informática</center></p>
        </div>
    </section>


</section>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@yield('script')
</body>
</html>