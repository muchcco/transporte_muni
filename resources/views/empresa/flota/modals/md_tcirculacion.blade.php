<div class="modal-dialog modal-xl" role="document" >
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">ACTUALIZAR TARJETA DE CIRCULACION </h4>
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
                    <h5>Datos principales</h5>
                    <br />
                    <div class="row g-7 mb-6">
                        <div class="col-md-12 fv-row" >
                            <table class="tablas " >
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre del documento</th>
                                        <th>Carga de documento</th>
                                        <th>Ver documento</th>
                                        <th>Eliminar archivo</th>
                                    </tr>
                                </thead>
                                <tbody id="tarjer_circulacion">
                                    <tr>
                                        <td id="num_corr" data-id="1">1</td>
                                        <td id="nomenclatura">
                                            Solicitud dirigida al alcalde, con carácter de declaración jurada, donde conste los datos de la persona autorizada (persona natural o persona jurídica).
                                        </td>
                                        <td class="text-center">
                                            <input type="file" id="fileInput" onchange="handleFileChange(this)" data-id="1" />
                                            
                                            <label for="fileInput" id="customFileInput">
                                                <!-- Puedes agregar aquí tu icono personalizado, por ejemplo, una etiqueta <i> de FontAwesome -->
                                                <i class="fa fa-upload text-white"></i>
                                            </label>
                                        </td>
                                        <td >
                                            @foreach ($dato as $dat)
                                                @if ($dat->num_corr == '1')
                                                    {{ $dat->nombre_archivo }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td id="num_corr" data-id="2">2</td>
                                        <td id="nomenclatura">
                                            Numero de resolución autorizada.
                                        </td>
                                        <td>
                                            <input type="file" id="fileInput" onchange="handleFileChange(this)" data-id="2"  />
                                            <label for="fileInput" id="customFileInput">
                                                <!-- Puedes agregar aquí tu icono personalizado, por ejemplo, una etiqueta <i> de FontAwesome -->
                                                <i class="fa fa-upload text-white"></i>
                                            </label>
                                        </td>
                                        <td >
                                            @foreach ($dato as $dat)
                                                @if ($dat->num_corr == '2')
                                                    {{ $dat->nombre_archivo }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            Copia simple del contrato suscrito por la persona jurídica con cada uno de los propietarios de las unidades vehiculares registradas. Dicho contrato deberá establecer las condiciones básicas, como: compromisos y obligaciones que asume la persona jurídica y el propietario, condiciones de permanencia o exclusión de vehículos, plazo del contrato, el mismo que no deberá ser menor a un año, renovable por igual periodo por acuerdo de las partes.
                                        </td>
                                        <td>
                                            <input type="file" class="form-control">
                                        </td>
                                        <td ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>
                                            Copia simple del certificado SOAT físico, salvo que la información de la contratación del SOAT sea de acceso electrónico y/o AFOCAD cuando corresponda.
                                        </td>
                                        <td>
                                            <input type="file" class="form-control">
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>
                                            Numero de los Certificados de Inspección Técnica vehicular vigente.
                                        </td>
                                        <td>
                                            <input type="file" class="form-control">
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>
                                            Récord de infracciones del vehículo sin deuda, tanto en tránsito como en transporte (Adjuntar reporte de infracciones del PIT, y reporte de infracciones del área de transportes).
                                        </td>
                                        <td>
                                            <input type="file" class="form-control">
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>
                                            Derecho de pago por renovación.
                                        </td>
                                        <td>
                                            <input type="file" class="form-control">
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>
                                            Derecho de pago de constatación de características.
                                        </td>
                                        <td>
                                            <input type="file" class="form-control">
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>                                
                            </table>

                            
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
        </div>
    </div>
</div>

<script>


function handleFileChange(input) {
        // Aquí puedes realizar acciones cuando se selecciona un archivo, si es necesario
        console.log('Archivo seleccionado:', input.files[0].name);

        var nomenclatura = $("#nomenclatura").text().trim();
        var num_corr = $(input).data('id');

        var formData = new FormData();   
        var file_data = $("#fileInput").prop("files")[0];
        formData.append("ruta", file_data); 
        formData.append("idflota", "{{ $flota->idflota }}");
        formData.append("nomenclatura", nomenclatura);
        formData.append("num_corr", num_corr);
        formData.append("_token", $("#_token").val());

        $.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "{{ route('empresa.flota.update_tcirculacion') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result){            
                // $( "#tarjer_circulacion" ).load(window.location.href + " #tarjer_circulacion" ); 
                //$( "#tarjer_circulacion" ).html(result.html);
                setTimeout(function() {
                    var newTbodyContent = $(result).find('#tarjer_circulacion tbody').html();
                    $('#tarjer_circulacion tbody').html(newTbodyContent);
                    
                    console.log('Resultado de la carga:', result);
                    console.log('Nuevo contenido de tbody:', newTbodyContent);
                }, 100);
                setTimeout(function() {
        var newTbodyContent = $(result).find('#tarjer_circulacion tbody').html();
        $('#tarjer_circulacion tbody').html(newTbodyContent);
        
        console.log('Resultado de la carga:', result);
        console.log('Nuevo contenido de tbody:', newTbodyContent);
    }, 500);
            },
            error: function(jqxhr,textStatus,errorThrown){
                console.log(jqxhr.responseJSON.error);
                console.log(textStatus);
                console.log(errorThrown);          
                
                document.getElementById("btnEnviarForm").innerHTML = 'ENVIAR';
                document.getElementById("btnEnviarForm").disabled = false;
            }
        });
    }
</script>