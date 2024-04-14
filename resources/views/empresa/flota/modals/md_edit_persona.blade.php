<div class="modal-dialog modal-xl" role="document" style="max-width:70%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">EDITAR PERSONA </h4>
             <!--begin::Close-->
             <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                <span class="svg-icon svg-icon-2x">X</span>
            </div>
            <!--end::Close-->
        </div>
        <div class="modal-body">
            {{-- <h5>Ingresar los siguientes datos</h5> --}}
            
            <form action="" class="form" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />                
                <div id="seccion_personales" class="">
                    
                    <h5>Ingresar datos personales 
                    </h5>
                    <br />
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Tipo de Documento</label>
                            <select class="form-select form-select-solid" name="tipo_documento" id="tipo_documento" onchange="TDocumento(this.value);">
                                <option value="1" {{ $persona->tipo_documento == '1' ? 'seleceted' : '' }}>DNI</option>
                                <option value="2" {{ $persona->tipo_documento == '2' ? 'seleceted' : '' }}>Carnet de Extrangería</option>
                                <option value="3" {{ $persona->tipo_documento == '3' ? 'seleceted' : '' }}>Pasaporte</option>                                
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">N° de Documento</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-solid " id="dni" name="dni" value="{{ $persona->dni }}" />
                                <button type="button" class="btn btn-primary " id="buscar_dni" onclick="btnBuscarPersona()" >Buscar</button>
                            </div>
                            <span class="text-center text-danger" id="mensaje_error_dni"></span>
                        </div>
                        
                    </div>
                    
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Nombre</label>
                            <input type="text" class="form-control form-control-solid" id="nombre" name="nombre" value="{{ $persona->nombre }}" oninput="convertirAMayusculas(this)">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Apellido Paterno</label>
                            <input type="text" class="form-control form-control-solid" id="ape_pat" name="ape_pat" value="{{ $persona->apellido_pat }}"  oninput="convertirAMayusculas(this)">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 " id="ape_mat_class">Apellido Materno</label>
                            <input type="text" class="form-control form-control-solid"  id="ape_mat" name="ape_mat" value="{{ $persona->apellido_mat }}"  oninput="convertirAMayusculas(this)">
                        </div>
                    </div>

                    <h5>Datos del domicilio</h5>
                        <br />

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Departamento</label>
                            <select class="form-select form-select-solid" name="departamento" id="departamento" >
                                <option value="0" disabled>-- SELECCIONE UNA OPCION --</option>
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}"  {{ $departamento->id == $dep_persona->iddepartamento ? 'selected' : '' }} >{{ $departamento->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Provincia</label>
                            <select class="form-select form-select-solid" name="provincia" id="provincia" >
                                <option value="{{ $dep_persona->idprovincia }}" selected>{{ $dep_persona->name_prov }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 " id="ape_mat_class">Distrito</label>
                            <select class="form-select form-select-solid" name="distrito" id="distrito" >
                                <option value="{{ $dep_persona->iddistrito }}" selected>{{ $dep_persona->name_dist }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Sexo</label>
                            <select class="form-select form-select-solid" name="sexo" id="sexo" >
                                <option value="1" {{ $persona->sexo == '1' ? 'selected' : '' }} >Hombre</option>
                                <option value="2" {{ $persona->sexo == '2' ? 'selected' : '' }} >Mujer</option>                                                                    
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Direccion</label>
                            <input type="text" class="form-control form-control-solid" id="direccion" name="direccion" value="{{ $persona->direccion }}" oninput="convertirAMayusculas(this)">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Dirección de Referencia</label>
                            <input type="text" class="form-control form-control-solid"  id="dir_referencia" name="dir_referencia" value="{{ $persona->ref_direccion }}" oninput="convertirAMayusculas(this)">
                        </div>
                    </div>
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Teléfono</label>
                            <input type="text" class="form-control form-control-solid" id="celular" name="celular" value="{{ $persona->celular }}" >
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Correo</label>
                            <input type="text" class="form-control form-control-solid"  id="correo" name="correo" value="{{ $persona->correo }}" >
                        </div>
                    </div>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="btnUpdatePersona('{{ $persona->idpersona }}')">Guardar</button>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    $('#departamento').on('change', function() {
        var departamento_id = $(this).val();
        if (departamento_id) {
            var url = "{{ route('provincias', ['departamento_id' => ':departamento_id']) }}"; // Cambia 'tipo' a 'tipoid'
            url = url.replace(':departamento_id', departamento_id);

            $.ajax({
                type: 'GET',
                url: url, // Utiliza la URL generada con tipo
                success: function(data) {
                    $('#provincia').html(data);
                }
            });
        } else {
            $('#provincia').empty();
        }
    });

    $('#provincia').on('change', function() {
        var provincia_id = $(this).val();
        if (provincia_id) {
            var url = "{{ route('distritos', ['provincia_id' => ':provincia_id']) }}"; // Cambia 'tipo' a 'tipoid'
            url = url.replace(':provincia_id', provincia_id);

            $.ajax({
                type: 'GET',
                url: url, // Utiliza la URL generada con tipo
                success: function(data) {
                    $('#distrito').html(data);
                }
            });
        } else {
            $('#distrito').empty();
        }
    });
});

var TDocumento = (val) => {
    if(val == '1'){
        document.getElementById("ape_mat_class").classList.add("required");
        $('#dni').attr("maxlength", "8");
        $("#buscar_dni").show();
    }else if(val == '2' || val == '3'){
        
        document.getElementById("ape_mat_class").classList.remove("required");
        $('#dni').attr("maxlength", "12");
        $("#buscar_dni").hide();
    }
}

var convertirAMayusculas = (e) => {
    e.value = e.value.toUpperCase();
}


var btnBuscarPersona = () => {

var dni = document.getElementById("dni").value;
console.log(dni);

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('buscar_dni') }}",
        data: {"_token": "{{ csrf_token() }}", dni: dni},
        beforeSend: function () {
            document.getElementById("buscar_dni").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Bucando';
            document.getElementById("buscar_dni").disabled = true;
        },
        success: function(response){
            console.log(response)
            document.getElementById("buscar_dni").innerHTML = 'Buscar';
            document.getElementById("buscar_dni").disabled = false;
            if(response["status"] == 120) {
                console.log(response.data.nombre)

                document.getElementById('mensaje_error_dni').textContent = '';

                document.getElementById('nombre').value = response.data.nombre;
                document.getElementById('ape_pat').value = response.data.apellido_pat;
                document.getElementById('ape_mat').value = response.data.apellido_mat;

                var provincia_element = document.getElementById('provincia');

                if (provincia_element && response.provincia) {
                    provincia_element.options[0].textContent = response.provincia.name;
                } else {
                    console.error('Elemento select no encontrado o respuesta incorrecta.');
                }

                var distrito_element = document.getElementById('distrito');

                if (distrito_element && response.distrito) {
                    distrito_element.options[0].textContent = response.distrito.name;
                } else {
                    console.error('Elemento select no encontrado o respuesta incorrecta.');
                }


                // document.getElementById('provincia').selectElement.response.provincia.id.textContent  = response.provincia.name;
                // document.getElementById('distrito').value = response.distrito.id;
                document.getElementById('departamento').value = response.departamento.id;

                document.getElementById('sexo').value = response.data.sexo;
                document.getElementById('direccion').value = response.data.direccion;
                document.getElementById('dir_referencia').value = response.data.ref_direccion;
                document.getElementById('celular').value = response.data.celular;
                document.getElementById('correo').value = response.data.correo;
            }
            if(response["status"] == 130) {
                document.getElementById('mensaje_error_dni').textContent = '';
                
                document.getElementById('nombre').value = response.data.nombre;
                document.getElementById('ape_pat').value = response.data.apellido_pat;
                document.getElementById('ape_mat').value = response.data.apellido_mat;

                document.getElementById('departamento').value = '';

                document.getElementById('sexo').value = '';
                document.getElementById('direccion').value = '';
                document.getElementById('dir_referencia').value = '';
                document.getElementById('celular').value = '';
                document.getElementById('correo').value = '';


                var provincia_element = document.getElementById('provincia');

                if (provincia_element && response.provincia) {
                    provincia_element.options[0].textContent = response.provincia.name;
                } else {
                    provincia_element.innerHTML = '<option value="">--</option>';
                }

                var distrito_element = document.getElementById('distrito');

                if (distrito_element && response.distrito) {
                    distrito_element.options[0].textContent = response.distrito.name;
                } else {
                    distrito_element.innerHTML = '<option value="">--</option>';
                }

            }
            if(response["status"] == 100 ){

                document.getElementById('mensaje_error_dni').textContent = response.data.error;

                document.getElementById('nombre').value = '';
                document.getElementById('ape_pat').value = '';
                document.getElementById('ape_mat').value = '';

                document.getElementById('departamento').value = '';

                document.getElementById('sexo').value = '';
                document.getElementById('direccion').value = '';
                document.getElementById('dir_referencia').value = '';
                document.getElementById('celular').value = '';
                document.getElementById('correo').value = '';


                var provincia_element = document.getElementById('provincia');

                if (provincia_element && response.provincia) {
                    provincia_element.options[0].textContent = response.provincia.name;
                } else {
                    provincia_element.innerHTML = '<option value="">--</option>';
                }

                var distrito_element = document.getElementById('distrito');

                if (distrito_element && response.distrito) {
                    distrito_element.options[0].textContent = response.distrito.name;
                } else {
                    distrito_element.innerHTML = '<option value="">--</option>';
                }
            }
            if(response["status"]  == 110){

                document.getElementById('mensaje_error_dni').textContent = response.error;

                document.getElementById('nombre').value = '';
                document.getElementById('ape_pat').value = '';
                document.getElementById('ape_mat').value = '';

                document.getElementById('departamento').value = '';

                document.getElementById('sexo').value = '';
                document.getElementById('direccion').value = '';
                document.getElementById('dir_referencia').value = '';
                document.getElementById('celular').value = '';
                document.getElementById('correo').value = '';


                var provincia_element = document.getElementById('provincia');

                if (provincia_element && response.provincia) {
                    provincia_element.options[0].textContent = response.provincia.name;
                } else {
                    provincia_element.innerHTML = '<option value="">--</option>';
                }

                var distrito_element = document.getElementById('distrito');

                if (distrito_element && response.distrito) {
                    distrito_element.options[0].textContent = response.distrito.name;
                } else {
                    distrito_element.innerHTML = '<option value="">--</option>';
                }
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