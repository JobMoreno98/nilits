@if (Auth::check())
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NILITS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .icono {
            font-size: 50px;
            /* Tamaño del icono */
        }


    </style>
</head>

<body>

    <div class="container mt-5">
        <!-- Encabezado con el título y la opción de cerrar sesión -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"> <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;"></h1>

            <form method="POST" class="btn btn-danger mt-3" action="{{ route('logout') }}">
                @csrf
                <button class="btn text-light" type="submit">
                    Cerrar Sesión
                </button>
            </form>
        </div>

        <!-- Subtítulo -->
        <p class="text-secondary">Nivelación a la Licenciatura en Trabajo Social - CUCSH</p>

        <!-- Tarjetas de Opciones -->
        <div class="row text-center">
            <!-- Tarjeta Alumnos -->

                <div class="col-md-4 mb-4" >
                    <a href="{{route('alumnos')}}" style="color: black; font-family: arial; text-decoration: none ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Alumnos</h5>
                            <i class="fas fa-user-graduate" style="font-size: 50px;" ></i>
                            <p class="card-text">Gestión de los datos de los alumnos</p>
                        </div>
                    </div>
                </a>
                </div>

            <!-- Tarjeta Asesores -->
            <div class="col-md-4 mb-4">
                <a href="{{route('asesores')}}" style="color: black; font-family: arial; text-decoration: none ">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Asesores</h5>
                        <i class="fas fa-chalkboard-teacher" style="font-size: 50px;"></i>
                        <p class="card-text">Gestión de los datos de los asesores</p>
                    </div>
                </div>
                </a>
            </div>
            <!-- Tarjeta Tutores -->

            <div class="col-md-4 mb-4">
                <a href="{{ route('gestionar-tutores') }}" style="color: black; font-family: arial; text-decoration: none ">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Tutores</h5>
                        <i class="fas fa-book-reader" style="font-size: 50px;"></i>
                        <p class="card-text">Asignación de Tutores</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Tarjeta Numeralia -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('numeralia') }}" style="color: black; font-family: arial; text-decoration: none ">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Numeralia</h5>
                        <i class="fas fa-database" style="font-size: 50px;"></i>
                        <p class="card-text">Reportes de datos</p>
                    </div>
                </div>
            </div>
            <!-- Tarjeta Aspirantes -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('aspirante') }}" style="color: black; font-family: arial; text-decoration: none ">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Aspirantes</h5>
                        <i class="fas fa-user-circle" style="font-size: 60px;"></i>
                        <p class="card-text">Gestión de Aspirantes</p>
                    </div>
                </div>
            </div>
            <!-- Tarjeta Normatividad -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('normatividad') }}" style="color: black; font-family: arial; text-decoration: none ">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Normatividad</h5>
                        <i class="fas fa-book" style="font-size: 60px;"></i>
                        <p class="card-text">Documentación CUCSH</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap y sus dependencias JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.5/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</body>

</html>

@else
<script>
    window.location = "{{ url('/') }}";
</script>
@endif
