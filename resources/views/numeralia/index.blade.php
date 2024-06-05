@if (Auth::check())
    @extends('layouts/layout')

    @section('title', 'Gestión de Tutores')

    @section('content')
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="mb-0">
                    <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;">
                </h1>
                <form method="POST" class="btn btn-danger mt-3" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn text-light" type="submit">
                        Cerrar Sesión
                    </button>
                </form>
            </div>

            <h2 class="mb-4 text-light" style="background-color: rgb(82, 82, 255)">Numeralia</h2>

            <div class="d-flex">
                <div class="me-3">
                    <h4>Estudiantes por carrera</h4>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkHombres" name="checkHombres">
                        <label class="form-check-label" for="checkHombres">
                            Hombres
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkMujeres" name="checkMujeres">
                        <label class="form-check-label" for="checkMujeres">
                            Mujeres
                        </label>
                    </div>


                    {{-- <select class="form-control" id="semestre" name="semestre">
                    <option selected value="">Semestre</option>
                    <option value="1">Ene-Jul</option>
                    <option value="2">Ago-Dic</option>

                </select> --}}

                    {{-- <select class="form-control" id="anio" name="anio">
                    <option selected>Año</option>
                    @foreach ($collection as $item)
                        <option value="anio">{{anio}}</option>
                    @endforeach
                </select> --}}


                    <select class="form-control" id="carrera" name="carrera">
                        <option selected value="carrera">Carrera</option>
                        <option value="NILITS">Abogado</option>
                        <option value="NILITS1">Licenciatura en Antropología</option>
                        <option value="NILITS2">Licenciatura en Criminología</option>
                    </select>

                    <h4>Modalidades de titulación</h4>
                    <select class="form-control" id="tipoTitulacion" name="tipoTitulacion">
                        <option selected>Tipo deTitulacion</option>
                        <option value="tesis">Tesis</option>
                        <option value="prac">Practicas Profesionales</option>
                        <option value="exce">Excelencia Académica</option>
                        <option value="prom">Promedio</option>
                    </select>


                    {{-- <h4>Materia más reprobada</h4>
                    <select class="form-control" id="materia" name="materia">
                        <option selected value="materia">Materia</option>
                        <option value="Ética jurídica">Ética jurídica</option>
                        <option value="Derecho constitucional">Derecho constitucional</option>
                        <option value="materia">Three</option>
                    </select> --}}

                </div>



                <div style="flex-grow: 1; margin-left: 20px;">
                    <canvas id="myChart" style="width: 50%; height: 100px;"></canvas>
                </div>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

            <script>
                const ctx = document.getElementById('myChart').getContext('2d');
                let chart;

                function updateChart(data) {
                    if (chart) {
                        chart.destroy();
                    }

                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Hombres', 'Mujeres'],
                            datasets: [{
                                label: '# of Votes',
                                data: [data.hombres, data.mujeres],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                // function fetchData(endpoint) {
                //     $.ajax({
                //         url: endpoint,
                //         method: 'GET',
                //         success: function(response) {
                //             updateChart(response);
                //         }
                //     });
                // }
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const checkHombres = document.getElementById('checkHombres');
                    const checkMujeres = document.getElementById('checkMujeres');
                    // const inputSemestre = document.getElementById('semestre');
                    const inputCarrera = document.getElementById('carrera');
                    const inputTipoTitulacion = document.getElementById('tipoTitulacion');
                    // const inputMateria = document.getElementById('materia');


                    // Función para manejar el cambio de valor
                    function handleChange(event) {
                        const hombres = checkHombres.checked ? 'true' : 'false';
                        const mujeres = checkMujeres.checked ? 'true' : 'false';
                        // const semestreValue = inputSemestre.value;
                        const carreraValue = inputCarrera.value;
                        const tipoTitulacionValue = inputTipoTitulacion.value;
                        // const materiaValue = inputMateria.value;

                        const queryParams =
                            `hombres=${hombres}&mujeres=${mujeres}&carrera=${carreraValue}&tipoTitulacion=${tipoTitulacionValue}`;
                            //se borro para después agregar : &materia=${materiaValue}

                        // Obtener el protocolo y el dominio
                        const protocolo = window.location.protocol;
                        const dominio = window.location.hostname;

                        // Construir el endpoint
                        const endpoint = `${protocolo}//${dominio}:8000/grafica?${queryParams}`;


                        console.log(`Endpoint: ${endpoint}`);

                        // Realizar la solicitud AJAX
                        axios.get(endpoint)
                            .then(function(response) {
                                console.log(response.data)
                                updateChart(response.data);
                            })
                            .catch(function(error) {
                                console.error(error);
                            });
                    }

                    // Función para actualizar la gráfica
                    function updateChart(data) {
                        const labels = [];
                        const datasetData = [];

                        if (data.hombres !== undefined) {
                            labels.push('Hombres');
                            datasetData.push(data.hombres);
                        }

                        if (data.mujeres !== undefined) {
                            labels.push('Mujeres');
                            datasetData.push(data.mujeres);
                        }

                        if (chart) {
                            chart.destroy();
                        }

                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: '# of Votes',
                                    data: datasetData,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    // Agregar event listeners a los elementos
                    checkHombres.addEventListener('change', handleChange);
                    checkMujeres.addEventListener('change', handleChange);
                    // inputSemestre.addEventListener('change', handleChange);
                    inputCarrera.addEventListener('change', handleChange);
                    inputTipoTitulacion.addEventListener('change', handleChange);
                    // inputMateria.addEventListener('change', handleChange);


                    function identifyTitulacion() {
                        const tipoTitulacion = inputTipoTitulacion.value;
                        switch (tipoTitulacion) {
                            case 'tesis':
                                console.log('Seleccionado: TESIS');
                                break;
                            case 'prac':
                                console.log('Seleccionado: Practicas Profesionales');
                                break;
                            case 'exce':
                                console.log('Seleccionado: Excelencia Académica');
                                break;
                            case 'prom':
                                console.log('Seleccionado: Promedio');
                                break;
                            default:
                                console.log('Seleccionado: Tipo de Titulacion');
                        }
                    }
                });
            </script>

            <div class="text-center">
                <a href="{{ route('/home') }}" class="btn btn-secondary">Volver al menú</a>
            </div>
        </div>
    @endsection
@else
    <script>
        window.location = "{{ url('/') }}";
    </script>
@endif
