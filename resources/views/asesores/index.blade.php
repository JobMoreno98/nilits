@extends('layouts.layout')

@section('title', 'Gestionar profesores')

@section('content')
    <h2 class="mb-4  text-light" style="background-color: rgb(82, 82, 255)">Gestionar profesores</h2>

    <!-- Barra de búsqueda -->
    <input class="form-control mb-3" type="text" id="searchInput" placeholder="Buscar">

    <div class="table-responsive">
        <table class="table table-striped">
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
                        <td>{{ $maestro->Nombre }} {{ $maestro->Apellido }}</td>
                        <td>{{ $maestro->correo }}</td>
                        <td><a href="{{ route('asesor.show', $maestro->id) }}"> <i class="fas fa-edit"
                                    role="button"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <button class="btn text-light" style="background-color: rgb(0, 0, 169)" type="button" data-toggle="modal"
            data-target="#agregar">AGREGAR
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

        {{-- Modal para editar maestro --}}
        <div class="modal fade" id="editAsesor" tabindex="-1" role="dialog" aria-labelledby="editAlumnoModalLabel"
            aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAlumnoModalLabel">Editar Maestro
                            {{ $maestro->Nombre }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('/maestros/update/', ['codigo' => $maestro->codigo]) }}">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="modal-body">
                            <!-- Campos del formulario -->

                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo"
                                    value="{{ $maestro->codigo }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="Nombre" name="Nombre" required
                                    value="{{ $maestro->Nombre }}">
                            </div>
                            <div class="form-group">
                                <label for="Apellido">Apellidos</label>
                                <input type="text" class="form-control" id="Apellido" name="Apellido" required
                                    value="{{ $maestro->Apellido }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo"
                                    value="{{ $maestro->correo }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Telefono fijo</label>
                                <input type="text" class="form-control" id="telefonoFijo" name="telefonoFijo"
                                    value="{{ $maestro->telefonoFijo }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Telefono celular</label>
                                <input type="text" class="form-control" id="telCel" name="telCel"
                                    value="{{ $maestro->telCel }}">
                            </div>

                            <div class="form-group">
                                <label for="correo">Extencion</label>
                                <input type="number" class="form-control" id="telExt" name="telExt"
                                    value="{{ $maestro->telExt }}">
                            </div>

                            <div class="form-group">
                                <label for="nombramiento">Nombramiento</label>
                                <input type="text" class="form-control" id="nombramiento" name="nombramiento"
                                    value="{{ $maestro->nombramiento }}">
                            </div>
                            <div class="form-group">
                                <label for="cargaHoraria">Carga horaria</label>
                                <input type="text" class="form-control" id="cargaHoraria" name="cargaHoraria"
                                    value="{{ $maestro->cargaHoraria }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Adscripcion</label>
                                <input type="text" class="form-control" id="adscripcion" name="adscripcion"
                                    value="{{ $maestro->adscripcion }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Grado</label>
                                <input type="text" class="form-control" id="grado" name="grado"
                                    value="{{ $maestro->grado }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Observaciones</label>
                                <input type="text" class="form-control" id="observaciones" name="observaciones"
                                    value="{{ $maestro->observaciones }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar
                                Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <a href="{{ route('/home') }}" class="btn btn-secondary">Volver al menu</a>
    </div>
@endsection

@section('scripts')
    <!-- Script de búsqueda en la tabla -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('keyup', function() {
                var filter = searchInput.value.toUpperCase();
                var table = document.querySelector('table.table');
                var tr = table.getElementsByTagName('tr');

                // Recorre todas las filas de la tabla y oculta aquellas que no coincidan con la consulta de búsqueda
                for (var i = 1; i < tr.length; i++) {
                    var td = tr[i].getElementsByTagName('td')[
                        1]; // Columna 'Nombre' (ajustar el índice según sea necesario)
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
@endsection
