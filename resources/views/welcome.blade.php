@extends('layouts.login')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="text-center mb-4">
        <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;">
    </div>
    <form method="POST" action="{{ route('login') }}">
        <!-- Directiva Blade para el token CSRF -->
        @csrf
        <div class="form-group">
            <label for="inputUsuario">Usuario</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Usuario" required autofocus>
        </div>
        <div class="form-group">
            <label for="inputPassword">Contraseña</label>
            <input type="password" id="pass" name="pass" class="form-control" placeholder="Contraseña" required>
        </div>
        <button class="btn btn-lg text-light" style="background-color: rgb(0, 0, 169)" type="submit">Iniciar
            Sesión</button>
    </form>

    <a class="btn btn-lg  text-light" style="background-color: rgb(0, 0, 169)" href="{{ route('registro-usuario') }}">Darme de
        Alta</a>


    <a class="btn btn-lg  text-light" style="background-color: rgb(0, 0, 169)" href="{{ route('alumnado') }}">Ver
        Alumnado</a>
@endsection
