<div class="modal-dialog modal-xl" role="document" style="max-width:70%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">VER LA EMPRESA </h4>
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
                        <select class="form-select form-select-solid" name="tipo" id="tipo" disabled>
                            <option value="0" selected>{{ $query->tipo_nombre }} </option>
                        </select>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Categoria</label>
                        <select class="form-select form-select-solid" name="subtipo" id="subtipo" disabled>
                            <option value="0" selected>{{ $query->subt_nombre }} </option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row g-7 mb-6">
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-bold mb-2">RUC</label>
                        <input type="text" class="form-control form-control-solid" id="ruc" name="ruc" disabled value="{{ $query->ruc }}">
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Resolución</label>
                        <input type="text" class="form-control form-control-solid" id="resolucion" name="resolucion" disabled value="{{ $query->resolucion }}">
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Fecha de Registro</label>
                        <input type="date" class="form-control form-control-solid"  id="f_registro" name="f_registro" disabled value="{{ $query->fecha_registro }}"/>
                    </div>
                </div>

                <div class="row g-7 mb-6">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Razón Social</label>
                        <input type="text" class="form-control form-control-solid" id="r_social" name="r_social" disabled value="{{ $query->razon_social }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Fecha de Inicio</label>
                        <input type="date" class="form-control form-control-solid" id="f_inicio" name="f_inicio" disabled value="{{ $query->fecha_inicio }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Fecha Fin</label>
                        <input type="date" class="form-control form-control-solid"  id="f_fin" name="f_fin" disabled value="{{ $query->fecha_fin }}" />
                    </div>
                </div>

                <div class="row g-7 mb-6">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Cantidad de Flota Asignada a esta empresa</label>
                        <input type="text" class="form-control form-control-solid" id="cantidad_flota" name="cantidad_flota" disabled value="{{ $query->n_flota }}">
                    </div>
                </div>

                <div class="row g-7 mb-6">
                    <div class="col-md-12 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Ruta</label>
                        <textarea  class="form-control form-control form-control-solid" id="ruta" name="ruta" rows="10" disabled>                            
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
        </div>
    </div>
</div>