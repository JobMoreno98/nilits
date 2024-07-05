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
                    <h4>Estudiantes</h4>


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
                    <br>

                    <select class="form-control" id="estatus" name="estatus">

                    </select>

                    <select class="form-control" id="ciclo" name="ciclo">

                    </select>

                    <select class="form-control" id="ingreso" name="ingreso">

                    </select>

                    <select class="form-control" id="dictamen" name="dictamen">


                    </select>
                    <br>

                    <h4>Modalidades de titulación</h4>
                    <select class="form-control" id="tipoTitulacion" name="tipoTitulacion">

                    </select>


                </div>



                <div style="flex-grow: 1; margin-left: 20px;">
                    <canvas id="myChart" style="width: 50%; height: 100px;"></canvas>
                </div>

            </div>

            <div class="export-container">
                <button id="exportExcel" class="btn btn-primary mt-4">Exportar a Excel</button>
                <p class="note">Nota: Antes de oprimir el botón de exportar Excel, seleccione algún campo anterior.</p>
            </div>

            <style>
                .export-container {
                    display: flex;
                    align-items: center;
                    margin-top: 20px;
                }

                .note {
                    background-color: #f8d7da;
                    color: #721c24;
                    padding: 5px;
                    margin-left: 10px;
                    border: 1px solid #f5c6cb;
                    border-radius: 5px;
                    font-size: 12px;
                    max-width: 150px;
                    /* Ancho máximo para que parezca un cuadro */
                    text-align: center;
                    /* Centrar el texto */
                    display: inline-block;
                    /* Asegurar que el tamaño se ajuste al contenido */
                }
            </style>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


            <script>
                $(document).ready(function() {



                    $.ajax({
                        url: '{{ route('grafica-combo') }}',
                        method: 'GET',
                        success: function(response) {


                            $('#tipoTitulacion').append(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener los datos:', error);
                        }
                    });


                    console.log('s2332');
                    $.ajax({
                        url: '{{ route('grafica-dictamen') }}',
                        method: 'GET',
                        success: function(response) {

                            // console.log("datos data update:" + data.dictamen)
                            // console.log($dictamen)
                            $('#dictamen').append(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener los datos:', error);
                        }
                    });

                    $.ajax({
                        url: '{{ route('grafica-ciclo') }}',
                        method: 'GET',
                        success: function(response) {

                            $('#ciclo').append(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener los datos:', error);
                        }
                    });

                    $.ajax({
                        url: '{{ route('grafica-ingreso') }}',
                        method: 'GET',
                        success: function(response) {

                            $('#ingreso').append(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener los datos:', error);
                        }
                    });

                    $.ajax({
                        url: '{{ route('grafica-estatus') }}',
                        method: 'GET',
                        success: function(response) {
                            $('#estatus').append(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener los datos:', error);
                        }
                    });


                });





                const ctx = document.getElementById('myChart').getContext('2d');
                let chart;

                function updateChart(data) {


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
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const checkHombres = document.getElementById('checkHombres');
                    const checkMujeres = document.getElementById('checkMujeres');
                    const inputTipoTitulacion = document.getElementById('tipoTitulacion');
                    const inputDictamen = document.getElementById('dictamen');
                    const inputEstatus = document.getElementById('estatus');
                    const inputCiclo = document.getElementById('ciclo');
                    const inputIngreso = document.getElementById('ingreso');


                    // Función para manejar el cambio de valor
                    function handleChange(event) {
                        const hombres = checkHombres.checked ? 'true' : 'false';
                        const mujeres = checkMujeres.checked ? 'true' : 'false';
                        const dictamenValue = encodeURIComponent(inputDictamen.value.trim());
                        const tipoTitulacionValue = encodeURIComponent(inputTipoTitulacion.value.trim());
                        const estatusValue = encodeURIComponent(inputEstatus.value.trim());
                        const cicloValue = encodeURIComponent(inputCiclo.value.trim());
                        const ingresoValue = encodeURIComponent(inputIngreso.value.trim());

                        // console.log(dictamenValue)


                        // alert(tipoTitulacionValue)
                        const queryParams =
                            `hombres=${encodeURIComponent(hombres)}&mujeres=${encodeURIComponent(mujeres)}&dictamen=${dictamenValue}&ciclo=${cicloValue}&ingreso=${ingresoValue}&tipoTitulacion=${tipoTitulacionValue}&estatus=${estatusValue}`;

                        console.log('queryParams:', queryParams);

                        // Obtener el protocolo y el dominio
                        const protocolo = window.location.protocol;
                        const dominio = window.location.hostname;

                        // Construir el endpoint
                        const endpoint = `${protocolo}//${dominio}:8000/grafica?${queryParams}`;


                        console.log(`Endpoint: ${endpoint}`);

                        // Realizar la solicitud AJAX
                        axios.get(endpoint)
                            .then(function(response) {
                                console.log(response);
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

                        if (data.dictamen !== undefined) {
                            labels.push('dictamen');
                            datasetData.push(data.dictamen);
                        }

                        if (data.ciclo !== undefined) {
                            labels.push('ciclo');
                            datasetData.push(data.ciclo);
                        }

                        if (data.ingreso !== undefined) {
                            labels.push('ingreso');
                            datasetData.push(data.ingreso);
                        }

                        if (data.estatus !== undefined) {
                            labels.push('estatus');
                            datasetData.push(data.estatus);
                        }

                        if (data.tipoTitulacion !== undefined) {
                            labels.push('tipoTitulacion');
                            datasetData.push(data.tipoTitulacion);
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
                    inputTipoTitulacion.addEventListener('change', handleChange);
                    inputDictamen.addEventListener('change', handleChange);
                    inputEstatus.addEventListener('change', handleChange);
                    inputCiclo.addEventListener('change', handleChange);
                    inputIngreso.addEventListener('change', handleChange);

                });
            </script>

            <script>
                document.getElementById('exportExcel').addEventListener('click', function() {
                    const labels = chart.data.labels;
                    const data = chart.data.datasets[0].data;
                    let csvContent = "data:text/csv;charset=utf-8,";
                    csvContent += "Label,Value\n";

                    labels.forEach((label, index) => {
                        csvContent += `${label},${data[index]}\n`;
                    });

                    const encodedUri = encodeURI(csvContent);
                    const link = document.createElement("a");
                    link.setAttribute("href", encodedUri);
                    link.setAttribute("download", "numeralia.csv");
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                });
            </script>

            <br>
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
