@extends('layouts.externos')

@section('main')
    <h3><center>Ingresar a una de las opciones</center></h3>
    <div class="cuadros">
        <a href="{{ route('vehiculo') }}" class="cuadro-cont" style="background-color: #c70303;">Vehiculo</a>
        <a href="{{ route('conductor') }}" class="cuadro-cont" style="background-color: #259755">Conductor</a>
    </div>
@endsection