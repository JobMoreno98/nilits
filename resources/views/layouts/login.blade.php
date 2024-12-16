<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .login-container .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .form-control {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="d-flex w-100 h-100 align-items-center">
        <div class="d-none d-xl-block   col-xl-8 me-xl-2 h-100"
            style="background: url('{{ asset('imgs/prueba.jpg') }}');  background-repeat: no-repeat;  
  background-position: 0% 0%;
  background-size: 100% 100%;">

        </div>
        <div class="login-container m-auto">
            @yield('content')
        </div>

    </div>

    <!-- Bootstrap JS and its dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
