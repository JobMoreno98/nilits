@if (Auth::check())
    @extends('layouts.layout')

    @section('title', 'Tutorados')

    @section('content')
        <div class="container mt-5">
            <h2 class="mb-4 text-light p-1 px-3" style="border-radius: 0px 10px;background-color: rgb(82, 82, 255)">Gestión de
                tutorados</h2>
            <table class="table table-striped" id="example">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estatus</th>
                        <th>Último Dictamen</th>
                        <th>Datos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $alumno)
                        <tr>
                            <td>{{ $alumno->codigo }}</td>
                            <td>{{ $alumno->Nombre }}</td>
                            <td>{{ $alumno->correo }}</td>
                            <td>
                                @if ($alumno->estatus == 1)
                                    Activo
                                @elseif ($alumno->estatus == 3)
                                    Egresado
                                @elseif ($alumno->estatus == 4)
                                    Baja
                                @else
                                    Otro
                                @endif
                            </td>
                            <td>
                                @php
                                    $dictamenes = explode('.', $alumno->dictamen);
                                    natsort($dictamenes);
                                    $dictamenActual = end($dictamenes);
                                @endphp
                                {{ $dictamenActual }}
                            </td>
                            <td>
                                <i class="fas fa-edit edit-alumno-btn" role="button" data-toggle="modal"
                                    data-target="#editAlumnoModal" data-codigo="{{ $alumno->codigo }}"
                                    data-Nombre="{{ $alumno->Nombre }}"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
        <div class="modal fade" id="editAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="editAlumnoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAlumnoModalLabel">Datos del alumno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <!-- Campos del formulario -->
                            <input type="hidden" id="editCodigo" name="codigo" readonly>
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" value=""
                                    required readonly>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value=""
                                    required readonly>
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" id="correo" value="" name="correo"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="text" class="form-control" id="telefono" value="" name="telefono"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="ingreso">Calendario de ingreso</label>
                                <input type="text" class="form-control" name="ingreso" id="ingreso" value=""
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="genero">Genero</label>
                                <input type="text" class="form-control" id="genero" name="genero" value=""
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="procedencia">Procedencia</label>
                                <input type="text" class="form-control" id="procedencia" name="procedencia"
                                    value="" readonly>
                            </div>

                            <div class="form-group">
                                <label for="fechaNac">Fecha de Nacimiento</label>
                                <input type="text" class="form-control" id="fechaNac" name="fechaNac" value=""
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="calendarioTitulacion">Calendario de Egreso</label>
                                <input type="text" class="form-control" id="calendarioTitulacion"
                                    name="calendarioTitulacion" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="opcionTitulacion">Opción de Titulación</label>
                                <input type="text" class="form-control" id="opcionTitulacion" name="opcionTitulacion"
                                    value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fechaTitulacion">Fecha de titulación</label>
                                <input type="text" class="form-control" id="fechaTitulacion" name="fechaTitulacion"
                                    value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="estatus">Estatus del Alumno</label>

                            </div>
                            <div class="form-group">
                                <label for="acta">Acta</label>
                                <input type="text" class="form-control" id="acta" name="acta" value=""
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="libro">Libro</label>
                                <input type="text" class="form-control" id="libro" name="libro" value=""
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="dictamen">Dictámenes</label>
                                <ul>

                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
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
            new DataTable('#example', {
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
@endif
