@extends('layouts.layout')

@section('title', 'Gestionar Alumnos Sin Tutor')

@section('content')
    <div class="container mt-3 p-0">
        <h2 class="my-4 text-light" style="background-color: rgb(82, 82, 255)">Gestionar Alumnos sin tutor</h2>

        <div class="table-responsive">
            <table class="table table-striped" id="alumnos">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estatus</th>
                        <th>Ultimo Dictamen</th>
                        <th>Tutor</th>
                        <th>Datos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $alumno)
                    <tr>
                        <td>{{ $alumno->codigo }}</td>
                        <td>{{ $alumno->nombre_alumno }}</td>
                        <td>{{ $alumno->correo }}</td>
                        <td>
                            {!! $alumno->status !!}
                        </td>
                        <td>
                            {{ $alumno->dictamen_actual }}
                        </td>
                        <td>
                            @if (isset($alumno->tutores[0]))
                                {{ $alumno->tutores[0]->nombre }} {{ $alumno->tutores[0]->apellido }}
                            @else
                                Sin tutor
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('alumnos.show', $alumno->id) }}"><i class="fas fa-edit edit-alumno-btn"
                                    role="button"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('scripts')

    <script>
        $(document).ready(function() {
            $(document).on('click', '.edit-alumno-btn', function() {
                var codigo = $(this).data('codigo');
                console.log('success');
                $.ajax({
                    url: '{{ url('alumnos/detalles/all/') }}/' + codigo,
                    type: 'GET',
                    success: function(data) {
                        console.log('success');
                        $('#editAlumnoModalLabel').text('Editar Alumno ' + data.Nombre);
                        $('#editAlumnoModal #codigo').val(data.codigo);
                        $('#editAlumnoModal #nombre').val(data.Nombre);
                        $('#editAlumnoModal #correo').val(data.correo);
                        $('#editAlumnoModal #telefono').val(data.telefono);
                        $('#editAlumnoModal #opcionTitulacion').val(data.opcionTitulacion);
                        $('#editAlumnoModal #acta').val(data.acta);
                        $('#editAlumnoModal #acta').val(data.libro);

                        $('#editAlumnoModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <script>
        new DataTable('#alumnos', {
            "pageLength": 10,
            "order": [
                [0, "asc"]
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            responsive: true,
            // dom: 'Bfrtip',
            dom: '<"col-xs-3"l><"col-xs-5"B><"col-xs-4"f>rtip',
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Alumnos con tutor',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Alumnos con tutor',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                }
            ]
        });
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "portugues-pre": function(data) {
                var a = 'a';
                var e = 'e';
                var i = 'i';
                var o = 'o';
                var u = 'u';
                var c = 'c';
                var special_letters = {
                    "Á": a,
                    "á": a,
                    "Ã": a,
                    "ã": a,
                    "À": a,
                    "à": a,
                    "É": e,
                    "é": e,
                    "Ê": e,
                    "ê": e,
                    "Í": i,
                    "í": i,
                    "Î": i,
                    "î": i,
                    "Ó": o,
                    "ó": o,
                    "Õ": o,
                    "õ": o,
                    "Ô": o,
                    "ô": o,
                    "Ú": u,
                    "ú": u,
                    "Ü": u,
                    "ü": u,
                    "ç": c,
                    "Ç": c
                };
                for (var val in special_letters)
                    data = data.split(val).join(special_letters[val]).toLowerCase();
                return data;
            },
            "portugues-asc": function(a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "portugues-desc": function(a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
    </script>

@endsection
