<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-3gJwYp02bno6p0RrH+6Y1BZf1OBr2CZp2N4Wv0TtQ74="
        crossorigin="anonymous"></script>


    <!-- Incluir estilos CSS adicionales si los tienes -->
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link
        href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/datatables.min.css"
        rel="stylesheet">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #footer {
            margin-top: auto;
        }
    </style>

</head>

<body>
    <div id="preloader"></div>
    <nav class="navbar navbar-expand-md bg-light navbar-light w-100">
        <div class="container">
            <span class="me-2 pe-2 border-end border-dark">
                <a href="{{ route('/') }}"><img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt=""
                        width="75px"></a>
            </span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon "></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @can('Alumnos#ver')
                    <a class="text-decoration-none text-dark text-uppercase btn btn-border"
                        href="{{ route('alumnos') }}">Alumnos</a>
                    @endcan
                    @can('Asesores#ver')
                    <a href="{{ route('asesores') }}"
                        class="text-decoration-none text-dark text-uppercase btn btn-border">Asesores</a>
                    @endcan
                    {{--
                    @can('Tutores#ver')
                        <a href="{{ route('gestionar-tutores') }}"
                    class="text-decoration-none text-dark text-uppercase btn btn-border">Tutores</a>
                    @endcan --}}
                    @can('Numeralia#ver')
                    <a href="{{ route('numeralia') }}"
                        class="text-decoration-none text-dark text-uppercase btn btn-border">numeralia</a>
                    @endcan
                    @can('Aspirantes#ver')
                    <a href="{{ route('aspirantes.admin') }}"
                        class="text-decoration-none text-dark text-uppercase btn btn-border">Aspirantes</a>
                    @endcan
                    @can('Normatividad#ver')
                    <a href="{{ route('normatividad') }}"
                        class="text-decoration-none text-dark text-uppercase btn btn-border">normatividad</a>
                    @endcan
                    @can('Usuarios#ver')
                    <a href="{{ route('usuarios.index') }}"
                        class="text-decoration-none text-dark text-uppercase btn btn-border">Usuarios</a>
                    @endcan
                    @can('Tutorados#ver')
                    <a href="{{ route('tutor') }}"
                        class="text-decoration-none text-dark text-uppercase btn btn-border">tutorados</a>
                    @endcan
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('/') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="text-dark nav-link dropdown-toggle btn" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->nombre }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end text-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="w-100">
        @yield('content')
    </div>
    <div id="footer">
        <div class="col-sm-12 p-3 bg-light">
            <p class="text-center  m-0 text-uppercase">CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES |
                Nivelación a
                la Licenciatura en Trabajo Social </p>
        </div>

    </div>


    <!-- Incluir Bootstrap JS y sus dependencias -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/datatables.min.js">
    </script>


    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            showCloseButton: true
        });
    </script>
    @if (session('success'))
    <script>
        Toast.fire({
            title: "{!! session('success') !!}",
            icon: "success"
        });
    </script>
    @endif
    @if (session('error'))
    <script>
        Toast.fire({
            title: "{!! session('message') !!}",
            icon: "error"
        });
    </script>
    @endif
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>