<div class="modal-dialog modal-xl" role="document" >
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">DAR DE BAJA FLOTA </h4>
             <!--begin::Close-->
             <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                <span class="svg-icon svg-icon-2x">X</span>
            </div>
            <!--end::Close-->
        </div>
        <div class="modal-body">
            <form action="" class="form" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />                
                <div id="seccion_personales" >
                    <h5>Datos principales para baja</h5>
                    <br />
                    <div class="row g-7 mb-6">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Documento Sustentatorio</label>
                            <input type="file" class="form-control form-control-solid"  id="ruta_sustento" name="ruta_sustento"/>
                        </div>                       
                    </div>
                    <div class="row g-7 mb-6">
                        <div class="col-md-12 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Sustento</label>
                            <textarea  class="form-control form-control form-control-solid" id="sustento" name="sustento" >
                            </textarea>
                            
                        </div>
                    </div>
                </div>
                <p><strong>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                    Nota:
                    </strong> Al momento de dar de baja a los documentos, se guardan los datos en un histórico y se limpiara el formato para un nuevo ingreso.
                </p>
                
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-light-success" id="btnEnviarForm" onclick="btnBajaFlotaAccion('{{ $idflota }}')">Dar de Baja</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var textareaElement = document.getElementById('sustento');
    textareaElement.value = '';

});
</script>