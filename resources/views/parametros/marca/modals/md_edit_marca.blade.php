<div class="modal-dialog modal-xl" role="document" style="max-width:40%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">EDITAR MARCA </h4>
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
                    
                    <div class="row g-7 mb-6">
                        <div class="col-md-12 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Nombre de la Marca</label>
                            <input type="text" class="form-control form-control-solid"  id="name" name="name"  value="{{ $marca->nombre }}">
                        </div>
                    </div>
                </div>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="btnUpdateMarca('{{ $marca->idtipo_vehiculo }}')">Actulizar</button>
        </div>
    </div>
</div>

<script>
    
</script>