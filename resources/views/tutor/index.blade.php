@if (Auth::check())
    @extends('layouts.layout')

    @section('title', 'Tutorados')

    @section('content')
        <div class="container mt-5">
            <!-- Encabezado con el título y la opción de cerrar sesión -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0"> <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;"></h1>
                <form method="POST" class="btn btn-danger mt-3" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn text-light" type="submit">Cerrar Sesión</button>
                </form>
            </div>
            <h2 class="mb-4 text-light" style="background-color: rgb(82, 82, 255)">Gestión de tutorados</h2>
            <div class="table-responsive">
                <table class="table table-striped">
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
                                    data-target="#editAlumnoModal"
                                    data-codigo="{{ $alumno->codigo }}"
                                    data-Nombre="{{ $alumno->Nombre }}"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                                <input type="text" class="form-control" id="genero" name="genero" value="" readonly>
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


    @endsection
@endif
