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

    var idempresa = '{{ $empresa->idempresa }}';
    console.log(idempresa);

    $.ajax({
        type: 'GET',
        url: "{{ route('empresa.flota.tablas.tb_index') }}", // Ruta que devuelve la vista en HTML
        data: { idempresa: idempresa },
        beforeSend: function () {
            document.getElementById("table_data").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE LA TABLA ESTA CARGANDO... ';
        },
        success: function(data) {
            $('#table_data').html(data); // Inserta la vista en un contenedor en tu página
        }
    });
}

/* AGREGAMOS NUEVA FLOTA */


var AgregarFlota = (idempresa) => {

    console.log("g");
    $.ajax({
        type:'post',
        url: "{{ route('empresa.flota.modals.md_crea_flota') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}", idempresa : idempresa},
        success:function(data){
            $("#modal_ver_em").html(data.html);
            $("#modal_ver_em").modal('show');
        }
    });

}


var btnStoreFlota = () => {

    var idempresa = "{{ $empresa->idempresa }}";

    var formData = new FormData();
    formData.append("idempresa", idempresa);
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
        url: "{{ route('empresa.flota.store_flota') }}",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
            document.getElementById("btnEnviarForm").disabled = true;
        },
        success: function(response){       
            $("#modal_ver_em").modal('hide');     
            
            var idflota = response.idflota;

            var URLd = "{{ route('empresa.flota.flota_vista', ':idflota') }}".replace(':idflota', idflota);

            window.location.href = URLd;
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

var mdBajaFlota = (idflota) => {

    $.ajax({
        type:'post',
        url: "{{ route('empresa.flota.modals.baja_flota') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}", idflota : idflota},
        success:function(data){
            $("#modal_ver_em").html(data.html);
            $("#modal_ver_em").modal('show');
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
    
@endsection

@section('main')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class=" container-xxl ">

        <!--begin::Navbar-->
        <div class="card mb-6">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                {{-- <img src="/metronic8/demo8/assets/media/avatars/300-1.jpg" alt="image"> --}}
                                <div class="symbol-label  fw-semibold bg-primary text-inverse-primary" style="font-size: 8em">{{ $empresa->razon_social[0] }}</div>
                            </div>
                        </div>
                        <!--end::Pic-->

                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $empresa->razon_social }}</a>
                                        <a href="#">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                    <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF" />
                                                    <path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </div>
                                    <!--end::Name-->

                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></i> {{ $empresa->resolucion }}
                                        </a>
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span
                                                    class="path2"></span></i> {{ $empresa->ruc }}
                                        </a>
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-sms fs-4 me-1"><span class="path1"></span><span
                                                    class="path2"></span></i> {{ $empresa->fecha_registro }}
                                        </a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                            <!--end::Title-->

                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{ $empresa->n_flota }}" data-kt-countup-prefix="N°">{{ $empresa->n_flota }}</div>
                                                 
                                            </div>
                                            <!--end::Number-->

                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">N° de Flotas total</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--begin::Stat-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{ $total_flota }}" data-kt-countup-prefix="N°">{{ $total_flota }}</div>
                                            </div>
                                            <!--end::Number-->

                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">N° Flota registrado</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--begin::Stat-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{ $restante }}" data-kt-countup-prefix="N°">{{ $restante }}</div>
                                            </div>
                                            <!--end::Number-->

                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">Por registrar</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Progress-->
                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                        <span class="fw-semibold fs-6 text-gray-400">Empresa completada</span>
                                        <span class="fw-bold fs-6">{{ $porcentaje }}%</span>
                                    </div>

                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: {{ $porcentaje }}%;"
                                            aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <!--end::Progress-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                </div>
            </div>
            

        </div>
        <!--end::Container-->

        <div class="d-flex flex-wrap flex-stack mb-6">
            <!--begin::Heading-->
            <h3 class="fw-bolder my-2">Lista de Flotas asignadas a esta empresa
            <span class="fs-6 text-gray-400 fw-bold ms-1">Activos</span></h3>
            <!--end::Heading-->
            <!--begin::Actions-->
            <div class="d-flex flex-wrap my-2">
                <a href="{{ route('empresa.empresa') }}" class="btn btn-danger btn-sm " style="margin-right: 1em;">Regresar</a>
                <button  type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#large-Modal"  onclick="AgregarFlota('{{ $empresa->idempresa }}')">Nueva Flota</button>
            </div>
            <!--end::Actions-->
        </div>

        <div class="card mt-5 mt-xxl-8">
            <!--begin::Card body-->
            <div class="card-body">
                <div id="table_data">

                </div>               
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>

{{-- Ver Empresa--}}
<div class="modal fade" id="modal_ver_em" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"></div>

@endsection
