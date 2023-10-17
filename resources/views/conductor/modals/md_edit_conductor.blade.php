<div class="modal-dialog modal-xl" role="document" style="max-width:70%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">EDITAR CONDUCTOR </h4>
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
                    
                    <h5>Ingresar datos de la persona
                    </h5>
                    <br />
                    <div class="row g-7 mb-6">
                        <div class="col-md-12 fv-row">
                            <table class="tablas">
                                <thead class="bg-dark">
                                    <tr>
                                        <th class="text-white">N° de Padron</th>
                                        <th class="text-white">Nombre</th>
                                        <th class="text-white">Tipo de Documento</th>
                                        <th class="text-white">N° de Documento</th>
                                        <th class="text-white">Correo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>{{ $conductor->n_padron }} - {{ $conductor->año }}</th>
                                        <th>{{ $conductor->apellido_pat }} {{ $conductor->apellido_mat }}, {{ $conductor->nombre }} </th>
                                        <th>
                                            @if ($conductor->tipo_documento == '1')
                                                DNI
                                            @elseif ($conductor->tipo_documento == '2')
                                                Carnet de Extrangería
                                            @elseif ($conductor->tipo_documento == '3')
                                                Pasaporte
                                            @endif
                                        </th>
                                        <th>{{ $conductor->dni }}</th>
                                        <th>{{ $conductor->correo }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                    
                    </div>

                    <h5>Datos del conductor</h5>
                        <br />

                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Tipo de licencia (BREVETE)</label>
                            <select class="form-select form-select-solid" name="idcategoria_licencia" id="idcategoria_licencia" >
                                <option value="0" disabled>-- SELECCIONE UNA OPCION --</option>
                                @foreach ($tip_licencia as $licencia)
                                    <option value="{{ $licencia->idcategoria_licencia }}"  {{ $conductor->idcategoria_licencia == $licencia->idcategoria_licencia ? 'selected' : '' }} >{{ $licencia->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">N° de licencia (BREVETE)</label>
                            <input type="text" class="form-control form-control-solid" id="n_brevete" name="n_brevete" value="{{ $conductor->n_brevete }}" >
                        </div>
                    </div>
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Fecha de Expedición (BREVETE)</label>
                            <input type="date" class="form-control form-control-solid" id="fecha_expedicion_brevete" name="fecha_expedicion_brevete" value="{{ $conductor->fecha_expedicion_brevete }}" >
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2 ">Fecha de Vencimiento (BREVETE)</label>
                            <input type="date" class="form-control form-control-solid"  id="fecha_vencimiento_brevete" name="fecha_vencimiento_brevete" value="{{ $conductor->fecha_vencimiento_brevete }}" >
                        </div>
                    </div>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="btnSaveConductor('{{ $conductor->idconductor }}')">Guardar</button>
        </div>
    </div>
</div>