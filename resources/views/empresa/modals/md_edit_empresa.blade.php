<div class="modal-dialog modal-xl" role="document" style="max-width:70%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">EDITAR LA EMPRESA </h4>
             <!--begin::Close-->
             <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                <span class="svg-icon svg-icon-2x">X</span>
            </div>
            <!--end::Close-->
        </div>
        <div class="modal-body">
            <h5>Ingresar los siguientes datos</h5>
            <br />
            <form action="" class="form">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                <div class="row g-9 mb-8">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Tipo de Empresa</label>
                        <select class="form-select form-select-solid" name="tipo" id="tipo">
                            <option value="0">Seleccione una opción</option>
                            @foreach ($tipo as $t)
                                <option value="{{ $t->idtipo_empresa }}" {{ $t->idtipo_empresa == $query->idtipo_empresa ? 'selected' : '' }}>{{ $t->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Categoria</label>
                        <select class="form-select form-select-solid" name="subtipo" id="subtipo">
                            <option value="{{ $query->idsubtipo }}" selected>{{ $query->subt_nombre }} </option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row g-7 mb-6">
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-bold mb-2">RUC</label>
                        <input type="text" class="form-control form-control-solid" id="ruc" name="ruc" value="{{ $query->ruc }}">
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Resolución</label>
                        <input type="text" class="form-control form-control-solid" id="resolucion" name="resolucion" value="{{ $query->resolucion }}">
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Fecha de Registro</label>
                        <input type="date" class="form-control form-control-solid"  id="f_registro" name="f_registro" value="{{ $query->fecha_registro }}"/>
                    </div>
                </div>

                <div class="row g-7 mb-6">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Razón Social</label>
                        <input type="text" class="form-control form-control-solid" id="r_social" name="r_social" value="{{ $query->razon_social }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Fecha de Inicio</label>
                        <input type="date" class="form-control form-control-solid" id="f_inicio" name="f_inicio" value="{{ $query->fecha_inicio }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Fecha Fin</label>
                        <input type="date" class="form-control form-control-solid"  id="f_fin" name="f_fin" value="{{ $query->fecha_fin }}" />
                    </div>
                </div>

                <div class="row g-7 mb-6" >
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Cantidad de Flota</label>
                        <input type="text" class="form-control form-control-solid" id="cantidad_flota" name="cantidad_flota" value="{{ $query->n_flota }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Origen de ruta</label>
                        <input type="text" class="form-control form-control-solid" id="origen" name="origen" value="{{ $query->origen }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Destino de ruta</label>
                        <input type="text" class="form-control form-control-solid" id="destino" name="destino" value="{{ $query->destino }}">
                    </div>
                    {{-- <div class="col-md-3 fv-row" id="foto_div">
                        <label class="required fs-6 fw-bold mb-2">Foto de la empresa</label>
                        @if ($query->foto === NULL)
                            <input type="file" class="form-control form-control-solid" id="foto" name="foto"  accept="image/*">
                        @else
                            <p>{{ $query->foto }} <button type="button" class="btn btn-danger btn-sm" onclick="btnEliminarFoto('{{ $query->idempresa }}')">Eliminar</button></p>
                        @endif
                    </div> --}}
                </div>

                <div class="row g-7 mb-6">
                    <div class="col-md-12 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Ruta</label>
                        <textarea  class="form-control form-control form-control-solid" id="ruta" name="ruta" rows="10">                            
                            {{ $query->ruta }}
                        </textarea>
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="mt-2">
                        
                        
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="btnUpdateEmpresa('{{ $query->idempresa }}')">Actualizar</button>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#tipo').on('change', function() {
        var tipo = $(this).val();
        if (tipo) {
            var url = "{{ route('empresa.subtipo_id', ['tipoid' => ':tipo']) }}"; // Cambia 'tipo' a 'tipoid'
            url = url.replace(':tipo', tipo);

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

var btnEliminarFoto = (id) => {
    $.ajax({
        url: "{{ route('empresa.foto_eliminar') }}",
        type: 'post',
        data: {"_token": "{{ csrf_token() }}", id: id},
        success: function(data){
            $( "#foto_div" ).load(window.location.href + " #foto_div" ); 
        }
    });
}

</script>