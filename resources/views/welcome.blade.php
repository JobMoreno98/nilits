@extends('layouts.login')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="text-center mb-4">
        <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;">
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="inputUsuario">Usuario</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Usuario" required autofocus>
        </div>
        <div class="form-group">
            <label for="inputPassword">Contraseña</label>
            <input type="password" id="pass" name="pass" class="form-control" placeholder="Contraseña" required>
        </div>
        <button class="btn btn-sm text-light" style="background-color: rgb(0, 0, 169)" type="submit">Iniciar
            Sesión</button>
    </form>
    <a class="btn btn-sm text-light" style="background-color: rgb(0, 0, 169)" href="{{ route('registro-usuario') }}">Darme
        de Alta Profesor</a>
    <a class="btn btn-sm text-light" style="background-color: rgb(0, 0, 169)" href="{{ route('aspirantes.index') }}">Darme
        de Alta Aspirante</a>
@endsection
