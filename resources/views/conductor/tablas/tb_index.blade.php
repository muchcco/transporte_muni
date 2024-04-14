<table class="table table-bordered table-striped table-hover" id="table_conductor">
    <thead class="bg-dark" > 
        <tr>
            <th class="text-white">N° de padron</th>
            <th class="text-white">Nombres</th>
            <th class="text-white">DNI</th>
            <th class="text-white">Tipo brevete</th>
            <th class="text-white">N° de Brevete</th>
            <th class="text-white">Registro</th>
            <th class="text-white">Acciones</th>
        </tr>
    </thead>
    <tbody id="table_empresa_body">
        @foreach ($data as $i => $dat)
            <tr>
                <th>{{ $dat->n_padron }} </th>
                <th>{{ $dat->nombre }}</th>
                <th>{{ $dat->dni }}</th>
                <th>{{ $dat->desc_corta }}</th>
                <th>{{ $dat->n_brevete }}</th>
                <th>
                    @if ($dat->vehiculos_count == '0')
                        <a href="{{ route('conductor.reg_completo',$dat->idconductor) }}" class="btn btn-danger btn-sm">Completar Registro!</a>
                    @else
                        <a href="{{ route('conductor.reg_completo',$dat->idconductor) }}" class="btn btn-success btn-sm">Ver Registro</a>
                    @endif
                </th>
                <th>
                    <div class="d-flex justify-content-center flex-shrink-0">
                        <button class="btn btn-sm bandejTool" data-tippy-content="Eliminar empresa" onclick="EliminarConductor('{{ $dat->idconductor }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                        </button>
                        
                    </div>
                </th>
            </tr>
            
        @endforeach
    </tbody>
</table>

<script>
$(document).ready(function() {

    tippy(".bandejTool", {
        allowHTML: true,
        followCursor: true,
    });

    $('#table_conductor').DataTable({
        "responsive": true,
        "bLengthChange": false,
        "autoWidth": false,
        "searching": true,
        info: true,
        "ordering": false,
        "dom":
                "<'row'" +
                "<'col-sm-12 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-12 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-12 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">",
        language: {"url": "{{ asset('js/Spanish.json')}}"}, 
        "columns": [
            { "width": "" },
            { "width": "" },
            { "width": "" },
            { "width": "" },
            { "width": "" },
            { "width": "" },
            { "width": "" }
        ]
    });
});
</script>