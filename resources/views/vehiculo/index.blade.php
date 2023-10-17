@extends('layouts.layout')

@section('estilo')

<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>


<style>


</style>

@endsection

@section('script')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>


<script>

$(document).ready(function() {
    tabla_seccion();
});

var tabla_seccion = () => {


    $.ajax({
        type: 'GET',
        url: "{{ route('vehiculo.tablas.tb_index') }}", // Ruta que devuelve la vista en HTML
        data: {},
        beforeSend: function () {
            document.getElementById("table_data").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE LA TABLA ESTA CARGANDO... ';
        },
        success: function(data) {
            $('#table_data').html(data); // Inserta la vista en un contenedor en tu página
        }
    });
}

var btnAddvehiculo = () => {

    console.log("g");
    $.ajax({
        type:'post',
        url: "{{ route('vehiculo.modals.md_crea_vehiculo') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_em").html(data.html);
            $("#modal_add_em").modal('show');
        }
    });
}

var btnStoreVehiculo = () => {
    console.log("dd");
    if ($('#tipo_documento').val() == null  || $('#tipo_documento').val() == "0" ) {
        $('#tipo_documento').addClass("hasError");
    }else {
        $('#tipo_documento').removeClass("hasError");
    }
    if ($('#dni').val() == null  || $('#dni').val() == "" ) {
        $('#dni').addClass("hasError");
    }else {
        $('#dni').removeClass("hasError");
    }
    if ($('#nombre').val() == null  || $('#nombre').val() == "" ) {
        $('#nombre').addClass("hasError");
    }else {
        $('#nombre').removeClass("hasError");
    }
    if ($('#ape_pat').val() == null  || $('#ape_pat').val() == "" ) {
        $('#ape_pat').addClass("hasError");
    }else {
        $('#ape_pat').removeClass("hasError");
    }
    if ($('#ape_mat').val() == null  || $('#ape_mat').val() == "" ) {
        $('#ape_mat').addClass("hasError");
    }else {
        $('#ape_mat').removeClass("hasError");
    }
    if ($('#direccion').val() == null  || $('#direccion').val() == "" ) {
        $('#direccion').addClass("hasError");
    }else {
        $('#direccion').removeClass("hasError");
    }
    if ($('#dir_referencia').val() == null  || $('#dir_referencia').val() == "" ) {
        $('#dir_referencia').addClass("hasError");
    }else {
        $('#dir_referencia').removeClass("hasError");
    }
    if ($('#celular').val() == null  || $('#celular').val() == "" ) {
        $('#celular').addClass("hasError");
    }else {
        $('#celular').removeClass("hasError");
    }
    if ($('#departamento').val() == null  || $('#departamento').val() == "" ) {
        $('#departamento').addClass("hasError");
    }else {
        $('#departamento').removeClass("hasError");
    }
    if ($('#provincia').val() == null  || $('#provincia').val() == "" ) {
        $('#provincia').addClass("hasError");
    }else {
        $('#provincia').removeClass("hasError");
    }
    if ($('#distrito').val() == null  || $('#distrito').val() == "" ) {
        $('#distrito').addClass("hasError");
    }else {
        $('#distrito').removeClass("hasError");
    }
    if ($('#correo').val() == null  || $('#correo').val() == "" ) {
        $('#correo').addClass("hasError");
    }else {
        $('#correo').removeClass("hasError");
    }

    var formData = new FormData();
    
    formData.append("tipo_documento", $("#tipo_documento").val());
    formData.append("dni", $("#dni").val());
    formData.append("ruc", $("#ruc").val());
    formData.append("nombre", $("#nombre").val());
    formData.append("ape_pat", $("#ape_pat").val());
    formData.append("ape_mat", $("#ape_mat").val());
    formData.append("sexo", $("#sexo").val());
    formData.append("direccion", $("#direccion").val());
    formData.append("correo", $("#correo").val());
    formData.append("distrito", $("#distrito").val());
    formData.append("dir_referencia", $("#dir_referencia").val());
    formData.append("celular", $("#celular").val());
    formData.append("_token", $("#_token").val());

    $.ajax({
        type: "POST",
        dataType: "json",
        cache: false,
        url: "{{ route('vehiculo.store_vehiculo') }}",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
            document.getElementById("btnEnviarForm").disabled = true;
        },
        success: function(result){            
            
            tabla_seccion();
            $("#modal_add_em").modal('hide');

            Swal.fire(
                'Guardado!',
                'El registro se guardo con exito!',
                'success'
            )
        },
        error: function(jqxhr,textStatus,errorThrown){
            console.log(jqxhr.responseJSON.error);
            console.log(textStatus);
            console.log(errorThrown);          
            
            document.getElementById("btnEnviarForm").innerHTML = 'ENVIAR';
            document.getElementById("btnEnviarForm").disabled = false;
        }
    });


}

</script>
    
@endsection
@section('main')
    
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class=" container-xxl ">
            <div class="card card-bordered bordered-success ">
                <div class="card-header">
                    <h3 class="card-title">REGISTRO DE VEHICULO AUTORIZADOS PARA EL SERVICIO PUBLICO Y PRIVADO - HUANCAVELICA</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddvehiculo()">
                            Registrar Nuevo
                        </button>
                    </div>
                </div>
                <div class="card-body">
                   <div id="table_data">

                </div>   
                </div>
            </div>
        </div>
    </div>


{{-- Crear Empresa--}}
<div class="modal fade" id="modal_add_em" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"></div>

{{-- Ver Empresa--}}
<div class="modal fade" id="modal_ver_em" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"></div>

@endsection