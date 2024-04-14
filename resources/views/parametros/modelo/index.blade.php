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
        url: "{{ route('parametros.modelo.tablas.tb_index') }}", // Ruta que devuelve la vista en HTML
        data: {},
        beforeSend: function () {
            document.getElementById("table_data").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE LA TABLA ESTA CARGANDO... ';
        },
        success: function(data) {
            $('#table_data').html(data); // Inserta la vista en un contenedor en tu página
        }
    });
}

var btnAddModelo = () => {

    console.log("g");
    $.ajax({
        type:'post',
        url: "{{ route('parametros.modelo.modals.md_add_modelo') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_em").html(data.html);
            $("#modal_add_em").modal('show');
        }
    });
}

var btnStoreModelo = () => {

    var formData = new FormData();
    
    formData.append("marca", $("#marca").val());
    formData.append("modelo", $("#modelo").val());
    formData.append("_token", $("#_token").val());

    $.ajax({
        type: "POST",
        dataType: "json",
        cache: false,
        url: "{{ route('parametros.modelo.store_modelo') }}",
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
                'El usuario se registró con exito!',
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

var btnEditModelo = (id) => {

    console.log("editar");
    $.ajax({
        type:'post',
        url: "{{ route('parametros.modelo.modals.md_edit_modelo') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}", id : id},
        success:function(data){
            $("#modal_add_em").html(data.html);
            $("#modal_add_em").modal('show');
        }
    });
}

var btnUpdateModelo = (id) =>{

    var formData = new FormData();
    
    formData.append("modelo", $("#modelo").val());
    formData.append("id", id);
    formData.append("_token", $("#_token").val());

    $.ajax({
        type: "POST",
        dataType: "json",
        cache: false,
        url: "{{ route('parametros.modelo.update_modelo') }}",
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
                'El usuario se actualizo con exito!',
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
var EliminarModelo = (id) => {

    swal.fire({
        title: "Seguro que desea eliminar al usuario?",
        icon: "warning",
        // type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Si, Eliminar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
                $.ajax({
                    url: "{{ route('parametros.modelo.delete_modelo') }}",
                    type: 'post',
                    data: {_token: $('input[name=_token]').val(), id: id},
                    success: function(response){
                        tabla_seccion();
                        Swal.fire({ 
                            title: "Eliminado!",
                            icon: "success",
                            text: "El usuario ha sido eliminado",
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
                    <h3 class="card-title">Modelos registradas</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddModelo()">
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