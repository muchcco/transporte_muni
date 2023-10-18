@extends('layouts.layout')

@section('estilo')

<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>


<style>


</style>

@endsection

@section('script')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

@if (isset($flota_conductor->idpersona))
<script>
    $(document).ready(function() {
        tippy(".modal-tooglee", {
            allowHTML: true,
            followCursor: true,
        });
    });
    var btnEditPersona = (idconductor) => {
        console.log(idconductor);
        $.ajax({
            type:'post',
            url: "{{ route('conductor.modals.md_edit_persona') }}",
            dataType: "json",
            data:{"_token": "{{ csrf_token() }}", idconductor : idconductor},
            success:function(data){
                $("#modal_add_em").html(data.html);
                $("#modal_add_em").modal('show');
            }
        });
    }

    var btnUpdateConductor = (idpersona) => {

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
        formData.append("idpersona", idpersona);
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

        // Selector para mostrar el porcentaje
        var porcentajeElemento = $('#porcentaje');

        $.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "{{ route('conductor.update_conductor') }}",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando datos...';
                document.getElementById("btnEnviarForm").disabled = true;
            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        // Calcula el porcentaje de progreso y actualiza el elemento
                        var porcentaje = (e.loaded / e.total) * 100;
                        porcentajeElemento.text(porcentaje.toFixed(2) + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(result){            
                
                if(!(result.error)){
                    $("#modal_add_em").modal('hide');
                    $( "#act_persona" ).load(window.location.href + " #act_persona" );  
                    $( "#padron_number" ).load(window.location.href + " #padron_number" );
                    

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

                    toastr.success("El conductor se guardo con exito!", "Guardado:");
                }else{
                    $( "#act_persona" ).load(window.location.href + " #act_persona" ); ;
                    $("#modal_add_em").modal('hide');

                    Swal.fire(
                        'Error!',
                        'El conductor ya fue registrado!',
                        'error'
                    )
                }
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
   
    var btnAsigVehiculo = (idpersona) => {

        console.log(idpersona);
        $.ajax({
            type:'post',
            url: "{{ route('conductor.modals.md_vehiculo') }}",
            dataType: "json",
            data:{"_token": "{{ csrf_token() }}", idpersona : idpersona},
            success:function(data){
                $("#modal_add_em").html(data.html);
                $("#modal_add_em").modal('show');
            }
        });
    } 

    var btnSaveVehiculo = () =>{

        var idpersona = "{{ $conductor->idpersona }}";
        var idflota = "{{ $flota_empresa->idflota }}";
        var n_placa = $("#n_placa").val();

        var formData = new FormData();    
        formData.append("idpersona", idpersona);
        formData.append("categoria", $("#categoria").val());
        formData.append("subtipo", $("#subtipo").val());
        formData.append("n_placa", $("#n_placa").val());
        formData.append("combustible", $("#combustible").val());
        formData.append("serie", $("#serie").val());
        formData.append("color", $("#color").val());
        formData.append("año_fabricacion", $("#año_fabricacion").val());
        formData.append("n_asientos", $("#n_asientos").val());
        formData.append("motor", $("#motor").val());
        formData.append("carroceria", $("#carroceria").val());
        formData.append("_token", $("#_token").val());

        // Selector para mostrar el porcentaje
        var porcentajeElemento = $('#porcentaje_b');

        $.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "{{ route('conductor.store_vehiculo') }}",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando datos...';
                document.getElementById("btnEnviarForm").disabled = true;
                porcentajeElemento.text('0%');
            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        // Calcula el porcentaje de progreso y actualiza el elemento
                        var porcentaje = (e.loaded / e.total) * 100;
                        porcentajeElemento.text(porcentaje.toFixed(2) + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(result){            
                $("#modal_add_em").modal('hide');
                $( "#vehiculo_div" ).load(window.location.href + " #vehiculo_div" );             
                $( "#archivo_vehiculo_dat" ).load(window.location.href + " #archivo_vehiculo_dat" );
                porcentajeElemento.text('100%');

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

                    toastr.info("El conductor se guardo con exito!", "Guardado:");

                    // enviamos los datos para la actualizacion de la tb_emp_Flota del campo idvehiculo
                $.ajax({
                    type:'post',
                    url: "{{ route('empresa.flota.add_vehiculo') }}",
                    dataType: "json",
                    data:{"_token": "{{ csrf_token() }}", idflota : idflota, n_placa : n_placa, idpersona : idpersona},
                });
                
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

    var btnEditVehiculo = (idvehiculo, idpersona) =>{

        console.log(idvehiculo);
        $.ajax({
            type:'post',
            url: "{{ route('conductor.modals.md_vehiculo_edit') }}",
            dataType: "json",
            data:{"_token": "{{ csrf_token() }}", idvehiculo : idvehiculo, idpersona : idpersona},
            success:function(data){
                $("#modal_add_em").html(data.html);
                $("#modal_add_em").modal('show');
            }
        });

    }

    var btnUpdateVehiculo = (idvehiculo) => {


        var formData = new FormData();    
        formData.append("idvehiculo", idvehiculo);
        formData.append("categoria", $("#categoria").val());
        formData.append("subtipo", $("#subtipo").val());
        formData.append("n_placa", $("#n_placa").val());
        formData.append("combustible", $("#combustible").val());
        formData.append("serie", $("#serie").val());
        formData.append("color", $("#color").val());
        formData.append("año_fabricacion", $("#año_fabricacion").val());
        formData.append("n_asientos", $("#n_asientos").val());
        formData.append("motor", $("#motor").val());
        formData.append("carroceria", $("#carroceria").val());
        formData.append("_token", $("#_token").val());

        // Selector para mostrar el porcentaje

        $.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "{{ route('conductor.update_vehiculo') }}",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando datos...';
                document.getElementById("btnEnviarForm").disabled = true;
            },
            success: function(result){            
                $("#modal_add_em").modal('hide');
                $( "#vehiculo_div" ).load(window.location.href + " #vehiculo_div" ); 
                
                
                
                // porcentajeElemento.text('100%');

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

                    toastr.info("El conductor se guardo con exito!", "Guardado:");
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

    /* =================================================================== VALIDAR INPUT DE CARGA =================================================================== */

    function VarlidarDatos(){

        var r = { flag: true, mensaje: "" }

        //SELECCIONAMOS LOS COMBOS

        if ($("#ruta").val() == '' || $("#fecha_exp").val() == '' ||  $("#fecha_vence").val() == '' ||  $("#idtipo_dato").val() == '' ){

            r.flag = false;
            r.mensaje = "Debe ingresar todos los campos";
            return r;

        }

        return r;


    }

    /* =================================================================== FIN VALIDAR INPUT DE CARGA =============================================================== */


    var btnCargarArchivos = (idvehiculo) =>{
        r = VarlidarDatos();

        if(r.flag){
            var formData = new FormData();   
            var file_data = $("#ruta").prop("files")[0];
            formData.append("ruta", file_data); 
            formData.append("idvehiculo", idvehiculo);
            formData.append("fecha_exp", $("#fecha_exp").val());
            formData.append("fecha_vence", $("#fecha_vence").val());
            formData.append("idtipo_dato", $("#idtipo_dato").val());
            formData.append("_token", $("#_token").val());

            // Selector para mostrar el porcentaje
            var porcentajeElemento = $('#carga_prog');

            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
                url: "{{ route('vehiculo.store_tip_dato') }}",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    document.getElementById("cargadar_dato").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando datos...';
                    document.getElementById("cargadar_dato").disabled = true;
                    porcentajeElemento.text('0%');
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            // Calcula el porcentaje de progreso y actualiza el elemento
                            var porcentaje = (e.loaded / e.total) * 100;
                            porcentajeElemento.text(porcentaje.toFixed(2) + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(result){            
                    document.getElementById("cargadar_dato").innerHTML = '<i class="fa fa-regular fa-upload" style="color: #ffffff;"></i> Cargar';
                    document.getElementById("cargadar_dato").disabled = false;             
                    porcentajeElemento.text('100%');

                    $("#ruta").val('');
                    $("#fecha_exp").val('');
                    $("#fecha_vence").val('');

                    $( "#archivos_body" ).load(window.location.href + " #archivos_body" ); 
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

                        toastr.info("El conductor se guardo con exito!", "Guardado:");
                },
                error: function(jqxhr,textStatus,errorThrown){
                    document.getElementById("cargadar_dato").innerHTML = '<i class="fa fa-regular fa-upload" style="color: #ffffff;"></i> Cargar';
                    document.getElementById("cargadar_dato").disabled = false;
                    console.log(jqxhr.responseJSON.error);
                    console.log(textStatus);

                    
                }
            });
        }else{
            Swal.fire({
                icon: "warning",
                text: r.mensaje,
                confirmButtonText: "Aceptar"
            })
        }

        

    }

    var btnDeleteArchivo = (idvehiculo_archivo) => {

        swal.fire({
            title: "Seguro que desea eliminar el archivo?",
            text: "El archivo será eliminado totalmente de sus registros",
            icon: "error",
            showCancelButton: !0,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ route('conductor.delete_tip_dato') }}",
                    type: 'post',
                    data: {"_token": "{{ csrf_token() }}", idvehiculo_archivo: idvehiculo_archivo},
                    success: function(response){
                        console.log(response);

                        $( "#archivos_body" ).load(window.location.href + " #archivos_body" ); 

                        Swal.fire({
                            icon: "success",
                            text: "El archivo fue elimnado con Exito!",
                            confirmButtonText: "Aceptar"
                        })

                    },
                    error: function(error){
                        console.log('Error '+error);
                    }
                });
            }

        })
    }

    var mdBajaFlota = (idflota) => {

        $.ajax({
            type:'post',
            url: "{{ route('empresa.flota.modals.baja_flota') }}",
            dataType: "json",
            data:{"_token": "{{ csrf_token() }}", idflota : idflota},
            success:function(data){
                $("#modal_add_em").html(data.html);
                $("#modal_add_em").modal('show');
            }
        });

    }

    var btnBajaFlotaAccion = (idflota) =>{
        console.log(idflota)
        if ($('#ruta_sustento').val() == null  || $('#ruta_sustento').val() == "" ) {
            $('#ruta_sustento').addClass("hasError");
        }else {
            $('#ruta_sustento').removeClass("hasError");
        }

        if ($('#sustento').val() == null  || $('#sustento').val() == "" ) {
            $('#sustento').addClass("hasError");
        }else {
            $('#sustento').removeClass("hasError");
        }

        var formData = new FormData();
        var file_data = $("#ruta_sustento").prop("files")[0];
        formData.append("ruta_sustento", file_data);
        formData.append("idflota", idflota);
        formData.append("sustento", $("#sustento").val());
        formData.append("_token", $("#_token").val());

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('empresa.flota.store_baja') }}",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando...';
                document.getElementById("btnEnviarForm").disabled = true;
            },
            success: function(response){
                console.log(response)
                $("#modal_add_em").modal('hide');
                $( "#kt_content_container" ).load(window.location.href + " #kt_content_container" );
                window.location = window.location;

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

                toastr.success("A buena hora. Se dió de baja el registro... Ahora puedes sustituir una nueva flota.", "Se dio de baja!");

                
            },
            error: function(jqxhr,textStatus,errorThrown){
                console.log(jqxhr.responseJSON.error);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });


    }


    

</script>
@endif

<script>
var btnAgregarPersona = (idempresa, idflota) =>{

    console.log("g");
    $.ajax({
        type:'post',
        url: "{{ route('empresa.flota.modals.md_crea_flota') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}", idempresa : idempresa, idflota : idflota},
        success:function(data){
            $("#modal_add_em").html(data.html);
            $("#modal_add_em").modal('show');
        }
    });

}

var btnStoreFlota = () => {

var idflota = "{{ $flota_empresa->idflota }}";

var formData = new FormData();
formData.append("idflota", idflota);
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
    url: "{{ route('empresa.flota.update_flota') }}",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function () {
        document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
        document.getElementById("btnEnviarForm").disabled = true;
    },
    success: function(response){       
        $("#modal_add_em").modal('hide');     
        $( "#kt_content_container" ).load(window.location.href + " #kt_content_container" );
        window.location = window.location;
             
        
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
    <!--begin::Container-->
    <div id="kt_content_container" class=" container-xxl ">
        <div id="contenido_principal">
            @if (isset($flota_conductor->idpersona))
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xl-8">
                        
                            <!--begin::Card body-->
                            <div class="card-body">
                                
                                <!--begin::Summary-->
                                <!--begin::User Info-->
                                <div class="d-flex flex-center flex-column py-5" id="datos_principales">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-100px symbol-circle mb-7">
                                        {{-- <img src="assets/media/avatars/150-1.jpg" alt="image"> --}}
                                        <div class="symbol-label  fw-semibold bg-primary text-inverse-primary" style="font-size: 5em">{{ $conductor->apellido_pat[0] }}</div>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Name-->
                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{ $conductor->apellido_pat }} {{ $conductor->apellido_mat }}, {{ $conductor->nombre }}</a>
                                    <!--end::Name-->
                                    <!--begin::Position-->
                                    <div class="mb-9">
                                        <!--begin::Badge-->
                                        <div class="badge badge-lg badge-light-success d-inline">
                                            @if ($flota_conductor->sustitucion == 1)
                                                Registro Nuevo
                                            @else
                                                Sustitución
                                            @endif
                                            
                                        </div>
                                        <!--begin::Badge-->
                                    </div>
                                    <!--end::Position-->
                                    <!--begin::Info-->
                                    <!--begin::Info heading-->
                                    <div class="fw-bolder mb-3">N° de padron
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Correlativo para el año {{ $conductor->año }}" data-bs-original-title="" title=""></i></div>
                                    <!--end::Info heading-->
                                    <div class="d-flex flex-wrap flex-center" id="padron_number">
                                        <!--begin::Stats-->
                                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                            <div class="fs-4 fw-bolder text-gray-700">
                                                <span class="w-75px">{{ $conductor->n_padron }} - {{ $conductor->año }}</span>
                                            </div>
                                            <div class="fw-bold text-muted"></div>
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User Info-->
                                <!--end::Summary-->
                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Detalles de la Persona
                                    <span class="ms-2 rotate-180">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span></div>
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="Edit customer details">
                                        <button type="button" class="btn btn-sm btn-light-primary" data-toggle="modal" data-target="#large-Modal"  onclick="btnEditPersona('{{ $conductor->idpersona }}')">Editar</button>
                                    </span>
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator"></div>
                                <!--begin::Details content-->
                                <div id="kt_user_view_details" class="collapse show">
                                    <div class="pb-5 fs-6" id="act_persona">
                                        <div id="porcentaje"></div>
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">N° de documento</div>
                                        <div class="text-gray-600">{{ $conductor->dni }}</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">Correo</div>
                                        <div class="text-gray-600">
                                            <a href="#" class="text-gray-600 text-hover-primary">{{ $conductor->correo }}</a>
                                        </div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">Dirección</div>
                                        <div class="text-gray-600">{{ $conductor->direccion }}</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">Teléfono</div>
                                        <div class="text-gray-600">{{ $conductor->celular }}</div>
                                        <!--begin::Details item-->
                                    </div>
                                </div>
                                <!--end::Details content-->
                            </div>
                            <!--end::Card body-->
                            <div class="card-footer border-0 d-flex justify-content-end pt-0">
                                <a href="{{ route('empresa.flota.index', $flota_empresa->idempresa) }}" class="btn btn-sm btn-light-info">Regresar</a>
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Sidebar-->
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">Vehículo</a>
                            </li>
                            <li class="nav-item ms-auto">
                                <!--begin::Action menu-->
                                <button type="button" class="btn btn-danger ps-7" data-toggle="modal" data-target="#large-Modal"  onclick="mdBajaFlota('{{ $flota_conductor->idflota }}')">Baja
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-2 me-0">
                                
                                    <svg id="baja-1" xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>#baja-1{fill:#ffffff}</style><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                                </span>
                                </button>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                                <!--begin::Card-->
                                <div class="card card-flush mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header mt-6">
                                        <!--begin::Card title-->
                                        <div class="card-title flex-column">
                                            <h2 class="mb-1">Datos del Vehículo</h2>
                                            <div class="fs-6 fw-bold text-muted">Asignado al conductor {{ $conductor->apellido_pat }} {{ $conductor->apellido_mat }}, {{ $conductor->nombre }}</div>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar" id="vehiculo_asig">
                                            @if (!($vehiculo))
                                                <button type="button" class="btn btn-light-danger btn-sm" data-toggle="modal" data-target="#large-Modal"  onclick="btnAsigVehiculo('{{ $conductor->idpersona }}')">
                                                <!--SVG file not found: media/icons/duotune/art/art008.svg-->
                                                Agregar Vehículo</button>
                                            @else
                                                <button type="button" class="btn btn-light-primary btn-sm" data-toggle="modal" data-target="#large-Modal"  onclick="btnEditVehiculo('{{ $vehiculo->idvehiculo }}', '{{ $conductor->idpersona }}')">
                                                <!--SVG file not found: media/icons/duotune/art/art008.svg-->
                                                Editar Vehículo</button>
                                            @endif
                                            
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body p-9 pt-4">
                                    <div class="division" id="vehiculo_div">
                                            <div id="porcentaje_veh"></div>
                                            @if (!($vehiculo))
                                                <!--begin::Alert-->
                                                <div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                                                    

                                                    <!--begin::Icon-->
                                                    <span class="svg-icon svg-icon-5tx svg-icon-danger mb-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"></rect>
                                                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"></rect>
                                                        </svg>
                                                    </span>
                                                    <!--end::Icon-->

                                                    <!--begin::Wrapper-->
                                                    <div class="text-center">
                                                        <!--begin::Title-->
                                                        <h1 class="fw-bolder text-danger mb-5">FALTA INGRESAR DATOS</h1>
                                                        <!--end::Title-->

                                                        <!--begin::Separator-->
                                                        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                                                        <!--end::Separator-->

                                                        <!--begin::Content-->
                                                        <div class="mb-9 text-dark">
                                                            No hay datos disponibles en esta sección ya que usted no ha registrado al vehiculo.
                                                        </div>
                                                        <!--end::Content-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Alert-->
                                            @else
                                                <table class="tablas">
                                                    <tr>
                                                        <th>N° DE PADRON:</th>
                                                        <th colspan="3">{{ $vehiculo->n_padron }} - {{ $vehiculo->año }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>PLACA:</th>
                                                        <th colspan="3">{{ $vehiculo->n_placa }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>PROPIETARIO:</th>
                                                        <th colspan="3">{{ $conductor->apellido_pat }} {{ $conductor->apellido_mat }}, {{ $conductor->nombre }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>DOMICILIO:</th>
                                                        <th colspan="3">{{ $vehiculo->direccion }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>CAT.CLASE:</th>
                                                        <th>{{ $vehiculo->cat_clase }}</th>
                                                        <th>COMBUSTIBLE:</th>
                                                        <th>{{ $vehiculo->combustible }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>MARCA:</th>
                                                        <th>{{ $marca_v->name_marca }}</th>
                                                        <th>AÑO DE FABRICACION:</th>
                                                        <th>{{ $vehiculo->año_fabricacion }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>MODELO:</th>
                                                        <th>{{ $marca_v->name_modelo }}</th>
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
                                            @endif
                                    </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>

                                <div class="card card-flush mb-6 mb-xl-9">
                                    <div class="card-header mt-6">
                                        <div class="card-title flex-column">
                                            <h2 class="mb-1">Adjuntar Archivos</h2>
                                            <div class="fs-6 fw-bold text-muted">Subir los documentos sustentatorios en formato digital</div>
                                        </div>
                                        <div class="card-body p-9 pt-4">
                                            <div class="division" id="archivo_vehiculo_dat">
                                                @if ($archivos == NULL)
                                                    <div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                                                            

                                                        <!--begin::Icon-->
                                                        <span class="svg-icon svg-icon-5tx svg-icon-danger mb-5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"></rect>
                                                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"></rect>
                                                            </svg>
                                                        </span>
                                                        <!--end::Icon-->

                                                        <!--begin::Wrapper-->
                                                        <div class="text-center">
                                                            <!--begin::Title-->
                                                            <h1 class="fw-bolder text-danger mb-5">FALTA INGRESAR DATOS</h1>
                                                            <!--end::Title-->

                                                            <!--begin::Separator-->
                                                            <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                                                            <!--end::Separator-->

                                                            <!--begin::Content-->
                                                            <div class="mb-9 text-dark">
                                                                No hay datos disponibles en esta sección ya que usted no ha registrado al vehiculo.
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                @else
                                                    <div class="row g-7 mb-6">
                                                        <div class="col-md-6 fv-row">
                                                            <label class="required fs-6 fw-bold mb-2">Fecha Expedición</label>
                                                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" /> 
                                                            <input type="date" class="form-control form-control-solid" id="fecha_exp" name="fecha_exp">
                                                        </div>
                                                        <div class="col-md-6 fv-row">
                                                            <label class="required fs-6 fw-bold mb-2">Fecha vencimiento</label>
                                                            <input type="date" class="form-control form-control-solid" id="fecha_vence" name="fecha_vence">
                                                        </div>
                                                    </div>
                                                    <div class="row g-7 mb-6">
                                                        <div class="col-md-6 fv-row">
                                                            <label class="required fs-6 fw-bold mb-2">Tipo de ingreso</label>
                                                            <select class="form-select form-select-solid" name="idtipo_dato" id="idtipo_dato" >
                                                                @foreach ($tipo_dato as $f)
                                                                    <option value="{{ $f->idtipo_dato }}">{{ $f->descripcion }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>                                        
                                                        <div class="col-md-6 fv-row">
                                                            <label class="required fs-6 fw-bold mb-2 ">Documento</label>
                                                            <input type="file" class="form-control form-control-solid"  id="ruta" name="ruta"/>
                                                        </div>
                                                    </div>
                                                    <div class="row g-7 mb-6">
                                                        <div class="col-md-12 fv-row " >
                                                            <div class="d-grid gap-2">
                                                                <button class="btn btn-primary btn-sm"  id="cargadar_dato" onclick="btnCargarArchivos('{{ $vehiculo->idvehiculo }}')">
                                                                    <i class="fa fa-regular fa-upload" style="color: #ffffff;"></i>
                                                                    Cargar 
                                                                </button>
                                                            </div>                                            
                                                        </div>
                                                    </div>

                                                    <div class="row g-7 mb-6">
                                                        <div class="col-md-12 fv-row">
                                                            <table class="table table-hover table-rounded table-striped border gy-7 gs-7" id="archivos_body">
                                                                <thead class="bg-dark">
                                                                    <tr>
                                                                        <th class="text-white">N°</th>
                                                                        <th class="text-white">Tipo</th>
                                                                        <th class="text-white">Fecha de Vencimiento</th>
                                                                        <th class="text-white">Descargar Archivo</th>
                                                                        <th class="text-white">Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody >
                                                                    @forelse ($archivos as $i => $arc)
                                                                        <tr>
                                                                            <th>{{ $i + 1 }}</th>
                                                                            <th>{{ $arc->descripcion }}</th>
                                                                            <th>{{ $arc->fecha_vencimiento }}</th>
                                                                            <th class="text-center">
                                                                                <a href="{{ asset($arc->ruta) }}" target="_blank" class="modal-tooglee" data-tippy-content="Descargar documento" >
                                                                                    <i class="fa fa-solid fa-download text-primary"></i>
                                                                                </a>
                                                                            </th>
                                                                            <th>
                                                                                <button class="btn btn-sm  modal-tooglee" data-tippy-content="Eliminar dato vehicular" onclick="btnDeleteArchivo('{{ $arc->idvehiculo_archivo }}')">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ad0000}</style><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                                                                </button>
                                                                                
                                                                            </th>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <th colspan="5" class="text-center text-danger" id="carga_prog">No hay flota registrada</th>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>                            
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end:::Tab pane-->
                        </div>
                        <!--end:::Tab content-->
                    </div>
                    <!--end::Content-->
                </div>
            @else
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Wrapper-->
                        <div class="card-px text-center py-20 my-10">
                            <!--begin::Title-->
                            <h2 class="fs-2x fw-bolder mb-10"> {{ $flota_empresa->razon_social }} te la Bienvenida!</h2>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <p class="text-gray-400 fs-4 fw-bold mb-10">Para poder mostrar los registros, es necesario que primero asigne la flota a un responsable</p>
                            <!--end::Description-->
                            <button type="button" class="btn btn-primary" onclick="btnAgregarPersona('{{ $flota_empresa->idempresa }}', '{{ $flota_empresa->idflota }}')">Añadir responsable!</button>
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Illustration-->
                        <div class="text-center px-4">
                            <img class="mw-100 mh-300px" alt="" src="{{ asset('assets/media/illustrations/sketchy-1/2.png')}}">
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            @endif
        </div>
        
    </div>
</div>

{{-- Ver Empresa--}}
<div class="modal fade" id="modal_add_em" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"></div>

@endsection
