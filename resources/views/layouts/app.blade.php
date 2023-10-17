<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        #principal{
            background-image: url("{{ asset('img/huancavelica.jpg') }}") !important;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            background-color: #66999; 
            opacity: .9;
        }
    </style>

</head>
<body id="principal">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container ">
                <a class="navbar-brand text-center" href="https://www.munihuancavelica.gob.pe/es/" target="_blank">
                    <img src="{{ asset('img/logo muni huancav.jpg') }}" alt="Logo Muni" width="100">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item"> 
                            <a class="nav-link" href="{{ url('/') }}" style="font-size: 1.5em">                                
                                SISTEMA DE REGISTRO DE VEHICULOS Y CONDUCTORES
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" >
            @yield('content')
        </main>
    </div>
</body>
</html>
