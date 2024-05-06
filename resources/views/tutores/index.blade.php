@if (Auth::check())

    @extends('layouts/layout')

    @section('title', 'Gestión de Tutores')

    @section('content')
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="mb-0"> <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;">
                </h1>
                <form method="POST" class="btn btn-danger mt-3" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn text-light" type="submit">
                        Cerrar Sesión
                    </button>
                </form>
            </div>


            <h2 class="mb-4 text-light" style="background-color: rgb(82, 82, 255)">Gestionar profesores</h2>

            <!-- Selector de Tutores -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="mb-5">
                        <select name="maestro" class="form-control" id="selectTutor">
                            <option value="">Selecciona un tutor</option>
                            @foreach ($maestros as $maestro)
                                <option  value="{{ $maestro->codigo }}" data-nombre="{{ $maestro->Nombre }}"
                                    data-carga-horaria="{{ $maestro->cargaHoraria }}"
                                    data-numero-tutorados="{{ $maestro->NumeroTutorados }}"
                                    data-grado="{{ $maestro->grado }}" data-nombramiento="{{ $maestro->nombramiento }}">
                                    {{ $maestro->Nombre }} {{ $maestro->Apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div id="infoMaestro">
                        <h3>Información del Maestro</h3>
                        <p id="cargaHoraria">Carga Horaria: </p>
                        <p id="numeroTutorados">Número de Tutorados: </p>
                        <p id="grado">Grado: </p>
                        <p id="nombramiento">Nombramiento: </p>
                        <!-- Botones o links para generar documentos -->



                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tutorados</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Los datos de los tutorados se cargarán aquí dinámicamente -->
                                        Por favor, seleccione un maestro para ver sus tutorados.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Ver Tutorados
                        </button>
                        <button id="asignarTutorBtn" class="btn btn-primary">Asignar Tutor</button>

                        <button id="btnOficioAsignacion" class="btn text-light "
                            style="background-color: rgb(0, 0, 169)">Oficio de Asignación</button>
                        <button id="btnConstanciaTutoria" class="btn text-light"
                            style="background-color: rgb(0, 0, 169)">Constancia de Tutoría</button>

                        <button class="btn btn-secondary" onclick="location.href='{{ url('/home') }}'">Volver al
                            Menú</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $alumno)
                        <tr>
                            <td> <input name="alumno" type="checkbox"> {{ $alumno->codigo }}</td>
                            <td>{{ $alumno->Nombre }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-5">
                {{ $alumnos->appends(request()->query())->links() }}
            </div>
        </div>




        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#selectTutor').change(function() {
                    var selected = $(this).find('option:selected');
                    var cargaHoraria = selected.data('carga-horaria') || 'No especificado';
                    var numeroTutorados = selected.data('numero-tutorados') || 'No especificado';
                    var grado = selected.data('grado') || 'No especificado';
                    var nombramiento = selected.data('nombramiento') || 'No especificado';

                    // Actualizar la información del maestro
                    $('#cargaHoraria').text("Carga Horaria: " + cargaHoraria);
                    $('#numeroTutorados').text("Número de Tutorados: " + numeroTutorados);
                    $('#grado').text("Grado: " + grado);
                    $('#nombramiento').text("Nombramiento: " + nombramiento);

                    // Aquí puedes añadir lógica para mostrar u ocultar los botones basado en la información disponible
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                var tutoradosData = ''; // Almacena los datos de los tutorados aquí

                // Evento change del select
                $('#selectTutor').change(function() {
                    var maestroId = $(this).val(); // Obtiene el ID del maestro seleccionado
                    if (maestroId) {
                        $.ajax({
                            url: 'maestros/tutorados/' +
                                maestroId, // Asegúrate de que esta URL es correcta
                            type: 'GET',
                            success: function(data) {
                                tutoradosData = '<h5>Tutorados</h5>'; // Reinicia la variable
                                if (data.length > 0) {
                                    data.forEach(function(tutorado) {
                                        // Ajusta esto según la estructura de tus datos
                                        tutoradosData += '<p>' + tutorado.Nombre +
                                            '<a href="javascript:void(0)" onclick="eliminarAsignado(' +
                                            tutorado.codigo +
                                            ')" }}>Remover asesorado</a> </p>';
                                        //console.log(data);
                                    });
                                } else {
                                    tutoradosData = '<p>No hay tutorados asignados.</p>';
                                }
                                // No necesitas mostrar el modal aquí; se mostrará a través del botón ya configurado para ello
                            },
                            error: function(error) {
                                console.log(error);
                                tutoradosData = '<p>Error al cargar los tutorados.</p>';
                            }
                        });
                    }
                });

                // Escucha el evento para abrir el modal
                $('#exampleModal').on('show.bs.modal', function() {
                    if ($('#selectTutor').val()) {
                        $('#exampleModal .modal-body').html(tutoradosData);
                    } else {
                        $('#exampleModal .modal-body').html(
                            '<p>Por favor, seleccione un maestro para ver sus tutorados.</p>');
                    }
                });
            });

            function eliminarAsignado(codigo) {
                if (confirm('¿Estás seguro de querer remover este asesorado?')) {
                    $.ajax({
                        url: '../public/elminarAsignado/' + codigo, // Asegúrate de que la URL es correcta
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}", // Necesario para la verificación CSRF en Laravel
                        },
                        success: function(result) {
                            // Recargar la página o realizar alguna acción para reflejar la eliminación
                            location.reload(); // Esto recargará la página
                        },
                        error: function(err) {
                            console.error(err);
                            alert('Ocurrió un error al eliminar el asesorado.');
                        }
                    });
                }
            }
        </script>




        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('btnConstanciaTutoria').addEventListener('click', function() {
                    var selectTutor = document.getElementById('selectTutor');
                    var codigoMaestro = selectTutor.value;

                    if (codigoMaestro) {
                        window.location.href = '{{ url('/generar-constancia-tutoria') }}' + '?codigo=' +
                            codigoMaestro;
                    } else {
                        alert('Por favor, selecciona un tutor antes de generar la constancia.');
                    }
                });
            });
        </script>


<script>
    document.getElementById('asignarTutorBtn').addEventListener('click', function() {
    var maestroSeleccionado = document.getElementById('selectTutor').value;
    var alumnosSeleccionados = [];
    document.querySelectorAll('input[name="alumno"]:checked').forEach(function(checkbox) {
        alumnosSeleccionados.push(checkbox.closest('td').textContent.trim()); // O alguna otra forma de obtener el código del alumno
    });

    if (maestroSeleccionado && alumnosSeleccionados.length > 0) {
        $.ajax({
            url: 'aplicaras',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "maestro": maestroSeleccionado,
                "alumno": alumnosSeleccionados
            },
            success: function(response) {
                alert('Tutorado asignado');
                location.reload();
                // Opcionalmente, resetear el formulario o actualizar la interfaz
            },
            error: function(xhr) {
                // Manejar errores (por ejemplo, mostrar mensajes)
                console.log(xhr.responseText);
            }
        });
    } else {
        alert('Por favor, seleccione un tutor y al menos un alumno.');
    }
});

</script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('btnOficioAsignacion').addEventListener('click', function() {
                    var selectTutor = document.getElementById('selectTutor');
                    var codigoMaestro = selectTutor.value;

                    if (codigoMaestro) {
                        window.location.href = '{{ url('/generar-oficio-asignacion') }}' + '?codigo=' +
                            codigoMaestro;
                    } else {
                        alert('Por favor, selecciona un tutor antes de generar la constancia.');
                    }
                });
            });
        </script>

    @endsection
@else
    <script>
        window.location = "{{ url('/') }}";
    </script>
@endif
