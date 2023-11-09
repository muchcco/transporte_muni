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
        url: "{{ route('empresa.tablas.tb_empresa') }}", // Ruta que devuelve la vista en HTML
        data: {},
        beforeSend: function () {
            document.getElementById("table_data").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE LA TABLA ESTA CARGANDO... ';
        },
        success: function(data) {
            $('#table_data').html(data); // Inserta la vista en un contenedor en tu página
        }
    });
}

var btnAddEmpresa = () => {

    console.log("g");
    $.ajax({
        type:'post',
        url: "{{ route('empresa.modals.md_crea_empresa') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_em").html(data.html);
            $("#modal_add_em").modal('show');
        }
    });

}


var btnStoreEmpresa = () => {
    console.log("g");
    if ($('#tipo').val() == null  || $('#tipo').val() == "0" ) {
        $('#tipo').addClass("hasError");
    }else {
        $('#tipo').removeClass("hasError");
    }
    if ($('#subtipo').val() == null  || $('#subtipo').val() == "" ) {
        $('#subtipo').addClass("hasError");
    }else {
        $('#subtipo').removeClass("hasError");
    }
    if ($('#ruc').val() == null  || $('#ruc').val() == "" ) {
        $('#ruc').addClass("hasError");
    }else {
        $('#ruc').removeClass("hasError");
    }
    if ($('#resolucion').val() == null  || $('#resolucion').val() == "" ) {
        $('#resolucion').addClass("hasError");
    }else {
        $('#resolucion').removeClass("hasError");
    }
    if ($('#f_registro').val() == null  || $('#f_registro').val() == "" ) {
        $('#f_registro').addClass("hasError");
    }else {
        $('#f_registro').removeClass("hasError");
    }
    if ($('#r_social').val() == null  || $('#r_social').val() == "" ) {
        $('#r_social').addClass("hasError");
    }else {
        $('#r_social').removeClass("hasError");
    }
    if ($('#f_inicio').val() == null  || $('#f_inicio').val() == "" ) {
        $('#f_inicio').addClass("hasError");
    }else {
        $('#f_inicio').removeClass("hasError");
    }
    if ($('#f_fin').val() == null  || $('#f_fin').val() == "" ) {
        $('#f_fin').addClass("hasError");
    }else {
        $('#f_fin').removeClass("hasError");
    }
    if ($('#cantidad_flota').val() == null  || $('#cantidad_flota').val() == "" ) {
        $('#cantidad_flota').addClass("hasError");
    }else {
        $('#cantidad_flota').removeClass("hasError");
    }
    if ($('#ruta').val() == null  || $('#ruta').val() == "" || !$('#ruta').val() ) {
        $('#ruta').addClass("hasError");
    }else {
        $('#ruta').removeClass("hasError");
    }

    var formData = new FormData();
    // var file_data = $("#foto").prop("files")[0];
    // formData.append("foto", file_data);
    
    formData.append("tipo", $("#tipo").val());
    formData.append("subtipo", $("#subtipo").val());
    formData.append("ruc", $("#ruc").val());
    formData.append("resolucion", $("#resolucion").val());
    formData.append("f_registro", $("#f_registro").val());
    formData.append("r_social", $("#r_social").val());
    formData.append("f_inicio", $("#f_inicio").val());
    formData.append("f_fin", $("#f_fin").val());
    formData.append("cantidad_flota", $("#cantidad_flota").val());
    formData.append("ruta", $("#ruta").val());
    formData.append("origen", $("#origen").val());
    formData.append("destino", $("#destino").val());
    formData.append("_token", $("#_token").val());

    $.ajax({
        type: "POST",
        dataType: "json",
        cache: false,
        url: "{{ route('empresa.e_store') }}",
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

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("La empresa se guardo con exito!", "Guardado:");
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

var VerEmpresa = (id) => {

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('empresa.modals.md_ver_empresa') }}",
        data: {"_token": "{{ csrf_token() }}", id: id},
        success: function(data){
            $("#modal_ver_em").html(data.html);
            $("#modal_ver_em").modal('show');
        },
        error: function(jqxhr,textStatus,errorThrown){
            console.log(jqxhr.responseJSON.error);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });


}

var EditarEmpresa = (id) => {

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('empresa.modals.md_edit_empresa') }}",
        data: {"_token": "{{ csrf_token() }}", id: id},
        success: function(data){
            $("#modal_ver_em").html(data.html);
            $("#modal_ver_em").modal('show');
        },
        error: function(jqxhr,textStatus,errorThrown){
            console.log(jqxhr.responseJSON.error);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });


}

var btnUpdateEmpresa = (id) => {
    var formData = new FormData();
    // var file_data = $("#foto").prop("files")[0];
    // formData.append("foto", file_data);
   
    formData.append("id", id);
    formData.append("tipo", $("#tipo").val());
    formData.append("subtipo", $("#subtipo").val());
    formData.append("ruc", $("#ruc").val());
    formData.append("resolucion", $("#resolucion").val());
    formData.append("f_registro", $("#f_registro").val());
    formData.append("r_social", $("#r_social").val());
    formData.append("f_inicio", $("#f_inicio").val());
    formData.append("f_fin", $("#f_fin").val());
    formData.append("origen", $("#origen").val());
    formData.append("destino", $("#destino").val());
    formData.append("cantidad_flota", $("#cantidad_flota").val());
    formData.append("ruta", $("#ruta").val());
    formData.append("_token", $("#_token").val());

    $.ajax({
        type: "POST",
        dataType: "json",
        cache: false,
        url: "{{ route('empresa.e_update') }}",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
            document.getElementById("btnEnviarForm").disabled = true;
        },
        success: function(result){            
            tabla_seccion();
            $("#modal_ver_em").modal('hide');
            
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.info("La empresa fue editada con exito!", "Editado:");
        },
        error: function(jqxhr,textStatus,errorThrown){
            console.log(jqxhr.responseJSON.error);
            console.log(textStatus);
            console.log(errorThrown);          
            
            document.getElementById("btnEnviarForm").innerHTML = 'Actualizar';
            document.getElementById("btnEnviarForm").disabled = false;
        }
    });
}

var EliminarEmpresa = (id) => {

    swal.fire({
        title: "Seguro que desea eliminar la empresa?",
        text: "La empresa y su flota será eliminado",
        icon: "info",
        showCancelButton: !0,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "{{ route('empresa.e_delete') }}",
                type: 'post',
                data: {"_token": "{{ csrf_token() }}", id: id},
                success: function(response){
                    tabla_seccion();
                    Swal.fire({ 
                        title: "Eliminado!",
                        icon: "success",
                        text: "La empresa fue eliminado del sistema",
                        confirmButtonText: "Aceptar"
                    });
                }
            });
        }

    })

}


</script>
    
@endsection
@section('main')
    
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class=" container-xxl ">
            <div class="card card-bordered bordered-success ">
                <div class="card-header">
                    <h3 class="card-title">EMPRESAS AUTORIZADAS DEL SERVICIO DE TRANSPORTE PUBLICO DE PASAJEROS URBANO - HUANCAVELICA</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddEmpresa()">
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