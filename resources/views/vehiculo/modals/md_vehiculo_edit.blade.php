<div class="modal-dialog modal-xl" role="document" style="max-width:70%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">   
                @if ($vehiculo->n_placa == NULL)
                    GUARDAR
                @else
                    EDITAR
                @endif

                VEHICULO 
            </h4>
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
                            <label class="required fs-6 fw-bold mb-2">Categoria</label>
                            <input type="text" class="form-control form-control-solid" id="categoria" name="categoria" oninput="convertirAMayusculas(this)" value="{{ $vehiculo->cat_clase }}">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Marca</label>
                            <select class="form-select form-select-solid" name="tipo" id="tipo" >
                                <option value="0" disabled>-- SELECCIONE UNA OPCION --</option>
                                @foreach ($tipo_v as $tipo)
                                    @if ($tipo_select == NULL)
                                        <option value="{{ $tipo->idtipo_vehiculo }}"  >{{ $tipo->min_nombre }}</option>
                                    @else
                                        <option value="{{ $tipo->idtipo_vehiculo }}"  {{ $tipo_select->idtipo_vehiculo == $tipo->idtipo_vehiculo ? 'selected': '' }} >{{ $tipo->min_nombre }}</option>
                                    @endif                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Modelo</label>
                            <select class="form-select form-select-solid" name="subtipo" id="subtipo" >
                                @if ($tipo_select == null)
                                    <option value="0"   >-- SELECCIONE UNA OPCION --</option>
                                @else
                                    <option value="{{ $tipo_select->idsubtipo_vehiculo }}"   >{{ $tipo_select->name_modelo }}</option>    
                                @endif                                
                            </select>
                        </div>
                    </div>
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">N° de Placa</label>
                            <input type="text" class="form-control form-control-solid" id="n_placa" name="n_placa"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->n_placa }}">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Combustible</label>
                            <input type="text" class="form-control form-control-solid"  id="combustible" name="combustible"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->combustible }}">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Serie</label>
                            <input type="text" class="form-control form-control-solid"  id="serie" name="serie"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->serie }}">
                        </div>
                    </div>

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Color</label>
                            <input type="text" class="form-control form-control-solid" id="color" name="color"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->color }}">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Año de Fabricación</label>
                            <input type="text" class="form-control form-control-solid"  id="año_fabricacion" name="año_fabricacion"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->año_fabricacion }}">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Asiento</label>
                            <input type="text" class="form-control form-control-solid"  id="n_asientos" name="n_asientos"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->n_asientos }}">
                        </div>
                    </div>

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Motor</label>
                            <input type="text" class="form-control form-control-solid" id="motor" name="motor"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->motor }}">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Carroceria</label>
                            <input type="text" class="form-control form-control-solid"  id="carroceria" name="carroceria"  oninput="convertirAMayusculas(this)" value="{{ $vehiculo->carroceria }}">
                        </div>
                    </div>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="btnUpdateVehiculo('{{ $vehiculo->idvehiculo }}')">Guardar</button>
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
});

var convertirAMayusculas = (e) => {
    e.value = e.value.toUpperCase();
}


</script>