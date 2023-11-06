<div class="modal-dialog modal-xl" role="document" style="max-width:50%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">AÑADIR UN NUEVO USUARIO </h4>
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
                        <div class="col-md-4 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Ingrese su nueva contraseña</label>
                            <input type="password" class="form-control form-control-solid"  id="password" name="password" >
                        </div>
                    </div>
                </div>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="update_password_usuario('{{ $edit->id }}')">Guardar</button>
        </div>
    </div>
</div>

<script>
    
</script>