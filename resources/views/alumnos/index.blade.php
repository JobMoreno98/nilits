@extends('layouts.layout')

@section('title', 'Gestionar Alumnos')

@section('styles')
    <style>
        svg {
            height: 20px;
            /* Oculta los SVG */
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
            <form method="POST" class="btn btn-danger mt-3" action="{{ route('logout') }}">
                @csrf
                <button class="btn text-light" type="submit">
                    Cerrar Sesión
                </button>
            </form>
        </div>
        <h2 class="mb-4 text-light" style="background-color: rgb(82, 82, 255)"  >Gestionar Alumnos</h2>

        <form action="{{ route('buscarAlumno/all') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control mr-5" placeholder="Buscar alumno por nombre o codigo" name="query">
                <div class="input-group-append">
                    <button class="btn text-light mr-3" style="background-color: rgb(0, 0, 169)"  type="submit">Buscar</button>
                </div>
                <div class="input-group-append ms-2">
                    <a class="btn btn-md btn-secondary btn-block text-light" href="{{ route('alumnos') }}">Limpiar busqueda</a>
                </div>
            </div>
        </form>


        <div class="row mb-3">
            <a href="{{ route('/alumnos/sintutor') }}" class="btn text-light col-md-2 mr-5" style="background-color: rgb(0, 0, 169)">Ver alumnos sin
                tutor</a>

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
                            <td>{{ $alumno->tutor_nombre }} {{$alumno->tutor_apellido}}</td>
                            <!-- Botón para activar el modal -->
                            <td>
                                <i class="fas fa-edit edit-alumno-btn" role="button" data-toggle="modal"
                                    data-target="#editAlumnoModal"
                                    data-codigo="{{ $alumno->codigo }}"
                                    data-Nombre="{{ $alumno->Nombre }}"></i>
                                <!-- Modal para editar alumno -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal para editar alumno -->

        <div class="modal fade" id="editAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="editAlumnoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAlumnoModalLabel">Editar Alumno</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('/alumnos/update/', $alumno->codigo) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <!-- Campos del formulario -->
                            <input type="hidden" id="editCodigo" name="codigo">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo"
                                    value="" required>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="" required>
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" id="correo" value=""
                                    name="correo">
                            </div>

                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="text" class="form-control" id="telefono" value=""
                                    name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Calendario de ingreso</label>
                                <select class="form-control" name="ingreso" id="ingreso">
                                    @php
                                        $startYear = 1990;
                                        $endYear = date('Y');
                                    @endphp

                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }} A">{{ $year }} A</option>
                                        <option value="{{ $year }} B">{{ $year }} B</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="genero">Genero</label>
                                <select class="form-control" id="genero" name="genero">
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
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

                            <div class="form-group">
                                <label for="fechaNac">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fechaNac" name="fechaNac">
                            </div>
                            <div class="form-group">
                                <label for="egreso">Calendario de Egreso</label>
                                <select class="form-control" name="calendarioTitulacion" id="calendarioTitulacion">
                                    @php
                                        $startYear = 1990;
                                        $endYear = date('Y');
                                    @endphp

                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }} A">{{ $year }} A</option>
                                        <option value="{{ $year }} B">{{ $year }} B</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="opcionTitulacion">Opción de Titulacion</label>
                                <input type="text" class="form-control" id="opcionTitulacion"
                                    name="opcionTitulacion">
                            </div>
                            <div class="form-group">
                                <label for="fechaTitulacion">Fecha de titulacion</label>
                                <input type="date" class="form-control" id="fechaTitulacion" name="fechaTitulacion">
                            </div>
                            <div class="form-group">
                                <label for="estatus">Estatus del Alumno</label>
                                <select class="form-control" id="estatus" name="estatus">
                                    <option value="1">Activo</option>
                                    <option value="4">Baja</option>
                                    <option value="3">Egresado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="acta">Acta</label>
                                <input type="text" class="form-control" id="acta" name="acta">
                            </div>
                            <div class="form-group">
                                <label for="libro">Libro</label>
                                <input type="text" class="form-control" id="libro" name="libro">
                            </div>
                            <div class="form-group">
                                <label for="dictamen">Dictámenes</label>
                                <input type="text" class="form-control" id="dictamenInput"
                                    placeholder="Añadir dictamen">
                                <div id="dictamenContainer"></div>
                                <input type="hidden" name="dictamen" id="dictamenHidden">
                            </div>
                            <h4>Listado de dictamenes</h4>
                            @php
                                $dictamenes = explode('.', $alumno->dictamen);
                            @endphp
                            <ul>
                                @foreach ($dictamenes as $dictamen)
                                    <input type="text" value="{{ $dictamen }}">
                                @endforeach
                            </ul>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="mb-5">
            {{ $alumnos->appends(request()->query())->links() }}
        </div>


        <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                                <input type="text" name="telefono" class="form-control" id="telefono"
                                    pattern="[0-9]*">
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
                                        <option value="{{ $tutor->codigo }}">{{ $tutor->Nombre }} {{$alumno->tutor_apellido}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Crear registro</button>
                        </form>
                        <!-- Aquí termina el formulario -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="text-center">
            <button class="btn text-light" style="background-color: rgb(0, 0, 169)" type="button" data-toggle="modal" data-target="#agregar">Agregar
                Alumno</button>
            <a href="{{ route('/home') }}" class="btn btn-secondary">Volver al menu</a>
        </div>
    </div>
@endsection

@section('scripts')


<!---->
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
