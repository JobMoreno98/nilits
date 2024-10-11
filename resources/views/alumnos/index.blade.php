@extends('layouts.layout')

@section('title', 'Gestionar Alumnos')

@section('content')
    <div class="container mt-3 p-0">
        <h2 class="mb-4 text-light p-1 px-3" style="border-radius: 0px 10px;background-color: rgb(82, 82, 255)">Gestionar
            Alumnos</h2>
        <div class="d-flex mb-3 align-items-center">
            <a href="{{ route('/alumnos/sintutor') }}"
                class="btn text-light col-md-2 me-1"style="background-color: rgb(0, 0, 169)">Ver alumnos sin
                tutor</a>

            <button class="btn text-light me-1" style="background-color: rgb(0, 0, 169)" type="button" data-bs-toggle="modal"
                data-bs-target="#agregar">Agregar
                Alumno</button>

            <!-- Estadísticas rápidas -->
            <div class="col-md-2 ml-5">
                <span>Total de registros: {{ $totalRegistros }}</span>
            </div>
            <div class="col-md-2">
                <span>Total de egresados: {{ $totalEgresados }}</span>
            </div>
            <div class="col-md-2">
                <span>Total de Activos: {{ $totalActivos }}</span>
            </div>
            <div class="col-md-2">
                <span>Total de Bajas: {{ $totalBajas }}</span>
            </div>
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
                        <th>Ultimo Dictamen</th>
                        <th>Tutor</th>
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
                            <td>{{ $alumno->tutor_nombre }} {{ $alumno->tutor_apellido }}</td>
                            <!-- Botón para activar el modal -->
                            <td>
                                <a href="{{ route('alumnos.show', $alumno->codigo) }}"><i
                                        class="fas fa-edit edit-alumno-btn" role="button"></i></a>

                                <!-- Modal para editar alumno -->
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
                        <form method="POST" action="{{ route('/alumnos/crear') }}">
                            @csrf
                            <!-- Código -->
                            <div class="form-group">
                                <label for="codigo">Codigo</label>
                                <input type="text" class="form-control" name="codigo" id="codigo" required>
                            </div>

                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="Nombre" required>
                            </div>

                            <!-- Teléfono -->
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="text" name="telefono" class="form-control" id="telefono" pattern="[0-9]*">
                            </div>

                            <!-- Correo -->
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" name="correo" class="form-control" id="correo">
                            </div>

                            <!-- Género -->
                            <div class="form-group">
                                <label for="genero">Genero</label>
                                <select class="form-control" name="sexo" id="sexo">
                                    <option value="0">Masculino</option>
                                    <option value="1">Femenino</option>
                                </select>
                            </div>

                            <!-- Procedencia -->
                            <div class="form-group">
                                <label for="procedencia">Procedencia</label>
                                <select class="form-control" name="procedencia">
                                    <option value="0">Aguascalientes</option>
                                    <option value="1">Baja California</option>
                                    <option value="2">Baja California Sur</option>
                                    <option value="3">Campeche</option>
                                    <option value="4">Chiapas</option>
                                    <option value="5">Chihuahua</option>
                                    <option value="6">Ciudad de México</option>
                                    <option value="7">Coahuila</option>
                                    <option value="8">Colima</option>
                                    <option value="9">Durango</option>
                                    <option value="10">Guanajuato</option>
                                    <option value="11">Guerrero</option>
                                    <option value="12">Hidalgo</option>
                                    <option value="13">Jalisco</option>
                                    <option value="14">México</option>
                                    <option value="15">Michoacán</option>
                                    <option value="16">Morelos</option>
                                    <option value="17">Nayarit</option>
                                    <option value="18">Nuevo León</option>
                                    <option value="19">Oaxaca</option>
                                    <option value="20">Puebla</option>
                                    <option value="21">Querétaro</option>
                                    <option value="22">Quintana Roo</option>
                                    <option value="23">San Luis Potosí</option>
                                    <option value="24">Sinaloa</option>
                                    <option value="25">Sonora</option>
                                    <option value="26">Tabasco</option>
                                    <option value="27">Tamaulipas</option>
                                    <option value="28">Tlaxcala</option>
                                    <option value="29">Veracruz</option>
                                    <option value="30">Yucatán</option>
                                    <option value="31">Zacatecas</option>
                                </select>
                            </div>
                            <!-- Fecha de Nacimiento -->
                            <div class="form-group">
                                <label for="fechaNac">Fecha de Nacimiento</label>
                                <input type="date" name="fechaNac" class="form-control" id="fechaNac">
                            </div>

                            <!-- Dictamenes -->
                            <div class="form-group">
                                <label for="dictamenes">Dictamenes</label>
                                <input type="text" class="form-control" id="dictamen" name="dictamen">
                            </div>
                            <div class="form-group">
                                <label for="genero">estatus</label>
                                <select class="form-control" name="estatus" id="estatus">
                                    <option value="1">Activo</option>
                                    <option value="4">Baja</option>
                                    <option value="3">Egresado</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="genero">tutor</label>
                                <select class="form-control" name="tutor" id="tutor">
                                    @foreach ($tutores as $tutor)
                                        <option value="{{ $tutor->codigo }}">{{ $tutor->Nombre }}
                                            {{ $alumno->tutor_apellido }}</option>
                                    @endforeach
                                </select>
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
