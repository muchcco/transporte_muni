<table class="table table-bordered table-striped table-hover" id="table_conductor">
    <thead class="bg-dark" > 
        <tr>
            <th class="text-white">N° de padron</th>
            <th class="text-white">N° de placa</th>
            <th class="text-white">Responsable</th>
            <th class="text-white">DNI</th>
            <th class="text-white">Afiliado a una empresa</th>            
            <th class="text-white">Registro</th>
            <th class="text-white">Acciones</th>
        </tr>
    </thead>
    <tbody id="table_empresa_body">
        @foreach ($data as $i => $dat)
            <tr>
                <th>{{ $dat->n_padron }} </th>
                <th>{{ $dat->n_placa }}</th>
                <th>{{ $dat->nombre }} {{ $dat->apellido_pat }} {{ $dat->apellido_mat }}</th>
                <th>{{ $dat->dni }}</th>
                <th>
                    @if ($dat->afiliado > '0')
                        <svg id="cont-1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>#cont-1{fill:#1e7113}</style><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                         Si esta afiliado
                    @else
                        <svg id="cont-2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>#cont-2{fill:#c93131}</style><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                        No esta afiliado
                    @endif
                </th>                
                <th>
                    @if ($dat->n_placa == null)
                        <a href="{{ route('vehiculo.reg_completo',$dat->idvehiculo) }}" class="btn btn-danger btn-sm">Completar Registro!</a>
                    @else
                        <a href="{{ route('vehiculo.reg_completo',$dat->idvehiculo) }}" class="btn btn-success btn-sm">Ver Registro</a>
                    @endif
                </th>
                <th>
                    <div class="d-flex justify-content-center flex-shrink-0">
                        <button class="btn btn-sm bandejTool" data-tippy-content="Eliminar empresa" onclick="EliminarConductor()">
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