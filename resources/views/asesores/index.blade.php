@extends('layouts.layout')

@section('title', 'Gestionar profesores')

@section('content')
    <div class="container mt-5 p-0">
        <h2 class="mb-4 text-light p-1 px-3" style="border-radius: 0px 10px;background-color: rgb(82, 82, 255)">Gestionar
            profesores</h2>

        <div class="table-responsive">
            <table class="table table-striped" id="example">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Datos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maestros as $maestro)
                        <tr>
                            <td>{{ $maestro->codigo }}</td>
                            <td>{{ $maestro->nombre }} {{ $maestro->apellido }}</td>
                            <td>{{ $maestro->correo }}</td>
                            <td>
                                <a href="{{ route('asesor.show', $maestro->codigo) }}" class="btn">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a target="_blank" class="btn" href="{{ route('oficio.asignacion', $maestro->id) }}">
                                    <i class="fa-solid fa-file-lines"></i>
                                </a>
                                <a target="_blank" href="{{ route('generar-constancia-tutoria', $maestro->id) }}"
                                    class="btn">
                                    <i class="fa-regular fa-file"></i>
                                </a>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <button class="btn text-light" style="background-color: rgb(0, 0, 169)" type="button" data-bs-toggle="modal"
                data-bs-target="#agregar">AGREGAR
                PROFESOR</button>

            {{-- Modal para añadir maestro --}}
            <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar assesor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('/maestros/store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código:</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo">
                                </div>

                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>

                                <div class="mb-3">
                                    <label for="apellido" class="form-label">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>

                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo:</label>
                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                </div>

                                <div class="mb-3">
                                    <label for="telefono_fijo" class="form-label">Teléfono Fijo:</label>
                                    <input type="number" class="form-control" id="telefono_fijo" name="telefono_fijo"
                                        maxlength="15" required>
                                </div>

                                <div class="mb-3">
                                    <label for="telefono_celular" class="form-label">Teléfono Celular:</label>
                                    <input type="text" class="form-control" id="telefono_celular" name="telefono_celular"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="extension" class="form-label">Extensión:</label>
                                    <input type="text" class="form-control" id="extension" name="extension" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nombramiento" class="form-label">Nombramiento:</label>
                                    <input type="text" class="form-control" id="nombramiento" name="nombramiento">
                                </div>

                                <div class="mb-3">
                                    <label for="carga_horaria" class="form-label">Carga Horaria:</label>
                                    <input type="text" class="form-control" id="carga_horaria" name="carga_horaria">
                                </div>

                                <div class="mb-3">
                                    <label for="adscripcion" class="form-label">Adscripción:</label>
                                    <input type="text" class="form-control" id="adscripcion" name="adscripcion">
                                </div>

                                <div class="mb-3">
                                    <label for="grado" class="form-label">Grado:</label>
                                    <input type="text" class="form-control" id="grado" name="grado">
                                </div>

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones:</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar</button>

                            </form>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
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
