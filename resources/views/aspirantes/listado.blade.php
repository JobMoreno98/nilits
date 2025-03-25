@extends('layouts.layout')

@section('title', 'Gestionar Aspirnates')

@section('content')
    <div class="container mt-3 p-0">
        <h2 class="mb-4 text-light p-1 px-3" style="border-radius: 0px 10px;background-color: rgb(82, 82, 255)">Gestionar
            Aspirantes</h2>
        <div class="d-flex flex-wrap mb-3 align-items-center justify-content-evenly">
            <button class="btn text-light me-1 btn-sm" style="background-color: rgb(0, 0, 169)" type="button"
                data-bs-toggle="modal" data-bs-target="#agregar">Agregar
                Aspirante</button>
        </div>

        <!-- Tabla de alumnos -->
        <div class="table-responsive">
            <table class="table table-striped" id="example">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estatus</th>
                        <th>Datos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aspirantes as $aspirante)
                        <tr>
                            <td>{{ $aspirante->codigo }}</td>
                            <td>{{ $aspirante->Nombre }}</td>
                            <td>{{ $aspirante->correo }}</td>
                            <td>
                                Aspirante
                            </td>
                            <td>
                                <a href="{{ route('alumnos.show', $aspirante->id) }}"><i class="fas fa-edit edit-alumno-btn"
                                        role="button"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="agregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí empieza el formulario -->
                        <form method="POST" action="{{ route('aspirantes.store') }}">
                            @csrf
                            <!-- Código -->
                            <div class="form-group">
                                <label for="codigo">Folio de Aspirante</label>
                                <input type="text" class="form-control" name="codigo" id="codigo"
                                    value="{{ old('codigo') }}" required>
                            </div>

                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre">Nombre completo</label>
                                <input type="text" name="nombre" class="form-control" id="Nombre"
                                    value="{{ old('nombre') }}" required>
                            </div>

                            <!-- Teléfono -->
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" id="telefono" pattern="[0-9]*"
                                    value="{{ old('telefono') }}">
                            </div>

                            <!-- Correo -->
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" name="correo" class="form-control" id="correo"
                                    value="{{ old('correo') }}">
                            </div>

                            <!-- Género -->
                            <div class="form-group">
                                <label for="genero">Género</label>
                                <select class="form-control" name="sexo" id="sexo" value="{{ old('sexo') }}">
                                    <option selected disabled>Elegir</option>
                                    <option value="0">Masculino</option>
                                    <option value="1">Femenino</option>
                                </select>
                            </div>
                            <!-- Procedencia -->
                            <div class="form-group mx-1 col-sm-12">
                                <label for="procedencia">Procedencia</label>
                                <select class="form-control" name="procedencia" id="procedencia"
                                    value="{{ old('procedencia') }}">
                                    <option disabled selected>Elegir..</option>
                                    @foreach ($estados as $key => $value)
                                        <option value="{{ $value }}">
                                            {{ $key + 1 . '-' . $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Fecha de Nacimiento -->
                            <div class="form-group">
                                <label for="fechaNac">Fecha de Nacimiento</label>
                                <input type="date" name="fechaNac" class="form-control" id="fechaNac"
                                    value="{{ old('fechaNac') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Crear registro</button>
                        </form>
                        <!-- Aquí termina el formulario -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

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
