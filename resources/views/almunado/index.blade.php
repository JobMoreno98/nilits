@extends('layouts.layout')

@section('title', 'Gestionar Alumnos')

@section('styles')
    <style>
        svg {
            height: 20px; /* Oculta los SVG */
        }
        .pagination-info {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="mb-0"> <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;"></h1>
            <a class="btn btn-danger text-light" href="{{ route('/') }}">Volver al inicio</a>
        </div>
        <h2 class="mb-4  text-light" style="background-color: rgb(82, 82, 255)">Gestionar Alumnos</h2>

        <form action="{{ route('/buscar-alumno/restricted') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control mr-5" placeholder="Buscar alumno por nombre o codigo" name="query">
                <div class="input-group-append">
                    <button class="btn text-light mr-3" style="background-color: rgb(0, 0, 169)"  type="submit">Buscar</button>
                </div>
                <div class="input-group-append ms-2">
                    <a class="btn btn-md btn-secondary btn-block text-light" href="{{ route('alumnado') }}">Limpiar busqueda</a>
                </div>
            </div>
        </form>

        <div class="row mb-3">
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
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estatus</th>
                        <th>Último Dictamen</th>
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
                            <td>{{ $alumno->tutor_nombre }} {{ $alumno->tutor_apellido }}  </td>
                            <!-- Botón para activar el modal -->
                            <td>
                                <i class="fas fa-edit edit-alumno-btn" role="button" data-toggle="modal" data-target="#editAlumnoModal{{ $alumno->codigo }}" data-codigo="{{ $alumno->codigo }}"></i>
                                <!-- Modal para editar alumno -->


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-5">
            {{ $alumnos->appends(request()->query())->links() }}
        </div>

        <!-- Botones de acción -->

    </div>

    <div class="modal fade" id="editAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="editAlumnoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlumnoModalLabel">Datos del alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <!-- Campos del formulario -->
                        <input type="hidden" id="editCodigo" name="codigo" readonly>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="" required readonly>
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" value="" name="correo" readonly>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="text" class="form-control" id="telefono" value="" name="telefono" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ingreso">Calendario de ingreso</label>
                            <input type="text" class="form-control" name="ingreso" id="ingreso" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="genero">Genero</label>
                            <input type="text" class="form-control" id="genero" name="genero" value="{{ $alumno->sexo == 1 ? 'Femenino' : 'Masculino' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="procedencia">Procedencia</label>
                            <input type="text" class="form-control" id="procedencia" name="procedencia" value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="fechaNac">Fecha de Nacimiento</label>
                            <input type="text" class="form-control" id="fechaNac" name="fechaNac" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="calendarioTitulacion">Calendario de Egreso</label>
                            <input type="text" class="form-control" id="calendarioTitulacion" name="calendarioTitulacion" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="opcionTitulacion">Opción de Titulación</label>
                            <input type="text" class="form-control" id="opcionTitulacion" name="opcionTitulacion" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="fechaTitulacion">Fecha de titulación</label>
                            <input type="text" class="form-control" id="fechaTitulacion" name="fechaTitulacion" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="estatus">Estatus del Alumno</label>
                            @if ($alumno->estatus == 1)
                                <input type="text" class="form-control" value="Activo" readonly>
                            @elseif ($alumno->estatus == 4)
                                <input type="text" class="form-control" value="Baja" readonly>
                            @elseif ($alumno->estatus == 3)
                                <input type="text" class="form-control" value="Egresado" readonly>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="acta">Acta</label>
                            <input type="text" class="form-control" id="acta" name="acta" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="libro">Libro</label>
                            <input type="text" class="form-control" id="libro" name="libro" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dictamen">Dictámenes</label>
                            <ul>
                                @foreach ($dictamenes as $dictamen)
                                    <input type="text" class="form-control" value="" readonly>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')


<script>
    jQuery(document).ready(function($) {
    $('.edit-alumno-btn').click(function() {
        var codigo = $(this).data('codigo');
        console.log('succes')
        $.ajax({
            url: 'alumnos/detalles/all/' + codigo ,
            type: 'GET',
            success: function(data) {
                console.log('succes')
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
<!---->
<script>
    jQuery(document).ready(function($) {
    $('.edit-alumno-btn').click(function() {
        var codigo = $(this).data('codigo');
        console.log('succes')
        $.ajax({
            url: 'alumnos/detalles/all/' + codigo ,
            type: 'GET',
            success: function(data) {
                console.log('succes')
                $('#editAlumnoModalLabel').text('Editar Alumno ' + data.Nombre);
                $('#editAlumnoModal #codigo').val(data.codigo);
                $('#editAlumnoModal #nombre').val(data.Nombre);
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
        document.addEventListener('DOMContentLoaded', (event) => {
            const dictamenInput = document.getElementById('dictamenInput');
            const dictamenContainer = document.getElementById('dictamenContainer');
            const dictamenHidden = document.getElementById('dictamenHidden');

            dictamenInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const dictamenValue = dictamenInput.value.trim();

                    if (dictamenValue) {
                        const newDictamen = document.createElement('span');
                        newDictamen.textContent = dictamenValue;
                        newDictamen.classList.add('dictamen-tag');

                        dictamenContainer.appendChild(newDictamen);
                        updateHiddenInput();

                        dictamenInput.value = '';
                    }
                }
            });

            function updateHiddenInput() {
                const allDictamenes = document.querySelectorAll('.dictamen-tag');
                const allDictamenValues = Array.from(allDictamenes).map(el => el.textContent);
                dictamenHidden.value = allDictamenValues.join('.');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('keyup', function() {
                var filter = searchInput.value.toUpperCase();
                var table = document.querySelector('table.table');
                var tr = table.getElementsByTagName('tr');

                // Recorre todas las filas de la tabla y oculta aquellas que no coincidan con la consulta de búsqueda
                for (var i = 1; i < tr.length; i++) {
                    var td = tr[i].getElementsByTagName('td')[1]; // Columna 'Nombre' (ajustar el índice según sea necesario)
                    if (td) {
                        var txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                        } else {
                            tr[i].style.display = 'none';
                        }
                    }
                }
            });
        });
    </script>
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
        $(document).ready(function() {
            $('#maestro').select2();
        });
    </script>
@endsection
