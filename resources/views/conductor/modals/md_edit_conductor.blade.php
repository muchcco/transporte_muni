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

                    <div class="row foto-dat">
                        <div class="row foto-dat-1">
                            <div class="row g-7 mb-6">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-bold mb-2">Tipo de licencia (BREVETE)</label>
                                    <select class="form-select form-select-solid" name="idcategoria_licencia" id="idcategoria_licencia" >
                                        <option value="0" disabled>-- SELECCIONE UNA OPCION --</option>
                                        @foreach ($tip_licencia as $licencia)
                                            <option value="{{ $licencia->idcategoria_licencia }}"  {{ $conductor->idcategoria_licencia == $licencia->idcategoria_licencia ? 'selected' : '' }} >{{ $licencia->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-bold mb-2">N° de licencia (BREVETE)</label>
                                    <input type="text" class="form-control form-control-solid" id="n_brevete" name="n_brevete" value="{{ $conductor->n_brevete }}" >
                                </div>
                                
                            </div>
                            <div class="row g-7 mb-6">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-bold mb-2">Fecha de Expedición (BREVETE)</label>
                                    <input type="date" class="form-control form-control-solid" id="fecha_expedicion_brevete" name="fecha_expedicion_brevete" value="{{ $conductor->fecha_expedicion_brevete }}" >
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-bold mb-2 ">Fecha de Vencimiento (BREVETE)</label>
                                    <input type="date" class="form-control form-control-solid"  id="fecha_vencimiento_brevete" name="fecha_vencimiento_brevete" value="{{ $conductor->fecha_vencimiento_brevete }}" >
                                </div>
                            </div>
                        </div>
                        <div class="row foto-dat-2" id="foto_actualiza">
                            <label for="">Foto del Conductor</label>
                            @if ($conductor->foto_conductor == NULL)
                                <div class="foto-conductor">                                
                                    <div id="fotoup">
                                        <img src="{{ asset('img/avatar-hombre.jpg') }}" alt="" class="img-foto-conductor" onchange="">
                                    </div>                                
                                </div>
                                <input type="file" class="form-control btn-input-foto" name="foto_conductor" id="foto_conductor" accept="image/png,image/jpeg">                                
                            @else
                                <div class="foto-conductor">                                
                                    <div id="fotoup">
                                        {{-- <img src="{{ asset('img/fotoconductor/.jpg') }}" alt="" class="img-foto-conductor" onchange=""> --}}
                                        <img src="{{ asset('img/fotoconductor/' . $conductor->foto_conductor . '') }}" alt="" class="img-foto-conductor">
                                        {{-- {{ $conductor->foto_coductor }} --}}
                                    </div>                                
                                </div>
                                {{-- <button class="btn btn-danger btn-sm btn-eliminar-foto">Eliminar</button> --}}
                                <input type="file" class="form-control btn-input-foto" name="foto_conductor" id="foto_conductor" accept="image/png,image/jpeg">       
                            @endif
                            
                        </div>   
                                             
                    </div>

                    
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Pagó derecho de empadronamiento? </label>
                            <select class="form-select form-select-solid" name="pago_padron" id="pago_padron" >
                                <option value="1" {{ $conductor->pago_padron == '1' ? 'selected' : '' }} >NO</option>
                                <option value="2" {{ $conductor->pago_padron == '2' ? 'selected' : '' }}>SI</option>
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">N° de recibo</label>
                            <input type="text" class="form-control form-control-solid" id="n_recibo" name="n_recibo" value="{{ $conductor->n_recibo }}" >
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Fecha y hora del recibo</label>
                            <input type="datetime-local" class="form-control form-control-solid"  id="fecha_recibo" name="fecha_recibo" value="{{ $conductor->fecha_recibo }}" >
                        </div>
                    </div>
                    <div class="row g-7 mb-6">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Monto (en soles)</label>
                            <input type="text" class="form-control form-control-solid"  id="monto_recibo" name="monto_recibo" value="{{ $conductor->monto_recibo }}" >
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

