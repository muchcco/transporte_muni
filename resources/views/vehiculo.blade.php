@extends('layouts.externos')

@section('main')
    <div id="error"></div>
    <h3><center>Ingrese el número de placa del vehiculo</center></h3>
    <div class="busqueda">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">N° de Placa (ejemplo: xxx-000)</label>
            <input type="text" class="form-control" id="n_placa" name="n_placa" >
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="button" onclick="btnBuscarPlaca()">Buscar</button>
            <a href="{{ route('externo') }}"  class="btn btn-danger" type="button" >
                <svg id="home" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>#home{fill:#f5f5f5}</style><path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                Regresar a Inicio
            </a>
        </div>
    </div>
@endsection


@section('script')

<script>

var btnBuscarPlaca = () =>{

    var n_placa = document.getElementById("n_placa").value;
    console.log(n_placa);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('search_vehiculo') }}",
        data: {"_token": "{{ csrf_token() }}", n_placa: n_placa},
        success: function(response){
            console.log(response)

            if(response.tipo_status == '2')
            {
                document.getElementById("error").innerHTML  = `<div class="alert alert-danger d-flex align-items-center" role="alert">
                                                                <p> Error `+ response.message +`
                                                           </div>`
            }
            else if(response.tipo_status == '1')
            {
                var id = response.data.idvehiculo;

                var URLd = "{{ route('view_vehiculo', ':id') }}".replace(':id', id);

                window.location.href = URLd;
            }

        },
        error: function(jqxhr,textStatus,errorThrown){
            console.log(jqxhr.responseJSON.error);
            console.log(textStatus);
            console.log(errorThrown);

            
        }
    });


}


</script>


@endsection