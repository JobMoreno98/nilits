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


            <h2 class="mb-4 text-light" style="background-color: rgb(82, 82, 255)">Numeralia</h2>

            <div>
                <h4>Estudiantes por carrera</h4>


                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" class="btn btn-primary">Hombre</button>
                    <button type="button" class="btn btn-primary">Mujer</button>

                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Carrera
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                        </ul>
                    </div>
                </div>

                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary">año</button>
                    <button type="button" class="btn btn-primary">semestre</button>
                </div>

                <h4>Titulación por modalidades</h4>

                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" class="btn btn-primary">hombre</button>
                    <button type="button" class="btn btn-primary">mujer</button>

                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                        </ul>
                    </div>
                </div>

                <h4>Materia mas reprobada</h4>


                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                    <button type="button" class="btn btn-primary">hombre</button>
                    <button type="button" class="btn btn-primary">mujer</button>

                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                        </ul>
                    </div>
                </div>
            </div>





            <div>
                <canvas id="myChart"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                        datasets: [{
                            label: '# Alumnos',
                            data: [12, 19, 3, 5, 2, 3],
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

                
            </script>


            <div class="text-center">

                <a href="{{ route('/home') }}" class="btn btn-secondary">Volver al menu</a>
            </div>




        </div>

    @endsection
@else
    <script>
        window.location = "{{ url('/') }}";
    </script>
@endif
