<div class="modal-dialog modal-xl" role="document" style="max-width:70%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">GUARDAR VEHICULO </h4>
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
                    <br />
                    <h5>Datos del vehiculo asignado al conductor - {{ $persona->apellido_pat }} {{ $persona->apellido_mat }}, {{ $persona->nombre }}</h5>
                        <br />
                    
                    <div class="row g-7 mb-6">
                        
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">N° de Placa</label>
                            <input type="text" class="form-control form-control-solid" id="n_placa" name="n_placa"  oninput="convertirAMayusculas(this)" >
                        </div>
                    </div>

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Categoria</label>
                            <input type="text" class="form-control form-control-solid" id="categoria" name="categoria" oninput="convertirAMayusculas(this)" >
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Marca</label>
                            <select class="form-select form-select-solid" name="tipo" id="tipo" >
                                <option value="0" disabled selected>-- SELECCIONE UNA OPCION --</option>
                                @foreach ($tipo_v as $tipo)
                                    <option value="{{ $tipo->idtipo_vehiculo }}"   >{{ $tipo->min_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Modelo</label>
                            <select class="form-select form-select-solid " name="subtipo" id="subtipo" >
                                <option value="0" disabled selected>-- SELECCIONE UNA OPCION --</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Combustible</label>
                            <input type="text" class="form-control form-control-solid"  id="combustible" name="combustible"  oninput="convertirAMayusculas(this)">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Serie</label>
                            <input type="text" class="form-control form-control-solid"  id="serie" name="serie"  oninput="convertirAMayusculas(this)">
                        </div>
                    </div>

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Color</label>
                            <input type="text" class="form-control form-control-solid" id="color" name="color"  oninput="convertirAMayusculas(this)">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Año de Fabricación</label>
                            <input type="text" class="form-control form-control-solid"  id="año_fabricacion" name="año_fabricacion"  oninput="convertirAMayusculas(this)">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Asiento</label>
                            <input type="text" class="form-control form-control-solid"  id="n_asientos" name="n_asientos"  oninput="convertirAMayusculas(this)">
                        </div>
                    </div>

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Motor</label>
                            <input type="text" class="form-control form-control-solid" id="motor" name="motor"  oninput="convertirAMayusculas(this)">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Carroceria</label>
                            <input type="text" class="form-control form-control-solid"  id="carroceria" name="carroceria"  oninput="convertirAMayusculas(this)">
                        </div>
                    </div>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="btnSaveVehiculo()">Guardar</button>
        </div>
    </div>
</div>



<script>

$(document).ready(function() {
    $('#tipo').on('change', function() {
        var subtipo = $(this).val();
        if (subtipo) {
            var url = "{{ route('subtipo_vehiculo', ['idsubtipo_vehiculo' => ':idsubtipo_vehiculo']) }}"; // Cambia 'tipo' a 'tipoid'
            url = url.replace(':idsubtipo_vehiculo', subtipo);

            $.ajax({
                type: 'GET',
                url: url, // Utiliza la URL generada con tipo
                success: function(data) {
                    $('#subtipo').html(data);
                }
            });
        } else {
            $('#subtipo').empty();
        }
    });

    $('#n_placa').on('change', function(){
        var n_placa = $(this).val();

        $.ajax({
            type: 'POST',
            url: "{{ route('buscar_placa') }}", 
            data: {"_token": "{{ csrf_token() }}", n_placa: n_placa},
            success: function(response) {
                // $('#subtipo').html(response);
                console.log(response);

                if(response["status"] == 100) {
                    document.getElementById('categoria').value = response.data.cat_clase;

                    var tipo = document.getElementById('tipo');
                    // document.getElementById('tipo').value = response.data.idmodelo;
                    if (tipo && response.tipo) {
                        tipo.options[0].textContent = response.tipo.nombre;
                    } else {
                        console.error('Elemento select no encontrado o respuesta incorrecta.');
                    }

                    var subtipo = document.getElementById('subtipo');
                    if (subtipo && response.subtipo && subtipo.options.length > 0) {
                        subtipo.options[0].textContent = response.subtipo.nombre;
                        var optionZero = subtipo.querySelector('option[value="0"]');    
                        if (optionZero) {
                            optionZero.textContent = response.subtipo.nombre;
                            optionZero.value = response.subtipo.idsubtipo_vehiculo;
                            optionZero.removeAttribute('disabled');
                            optionZero.removeAttribute('selected');
                        } else {
                            console.error('Opción con value="0" no encontrada.');
                        }
                    } else {
                        console.error('Elemento select no encontrado, respuesta incorrecta o opciones ausentes.');
                    }


                    document.getElementById('combustible').value = response.data.combustible;
                    document.getElementById('serie').value = response.data.serie;
                    document.getElementById('color').value = response.data.color;
                    document.getElementById('año_fabricacion').value = response.data.año_fabricacion;
                    document.getElementById('n_asientos').value = response.data.n_asientos;
                    document.getElementById('motor').value = response.data.motor;
                    document.getElementById('carroceria').value = response.data.carroceria;
                }
                
                
            }
        });
    });
});

var convertirAMayusculas = (e) => {
    e.value = e.value.toUpperCase();
}


</script>