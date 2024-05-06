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
    <button class="btn btn-lg text-light" style="background-color: rgb(0, 0, 169)" type="submit">Iniciar Sesión</button>
</form>

<button class="btn btn-lg  text-light" style="background-color: rgb(0, 0, 169)" type="button" data-toggle="modal"
    data-target="#registroProfesorModal">Darme de Alta</button>

<!-- Modal de Registro de Profesor -->
<div class="modal fade" id="registroProfesorModal" tabindex="-1" role="dialog"
    aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">Darse de alta en el sistema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registroProfesorForm" method="POST" action="{{ route('registro') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Código de profesor</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="pass" id="pass" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirma tu contraseña</label>
                        <input type="password" class="form-control" name="pass2" id="pass2" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn  btn-warning text-light" form="registroProfesorForm">Completar
                    Registro</button>
            </div>
        </div>
    </div>
</div>
<a class="btn btn-lg  text-light" style="background-color: rgb(0, 0, 169)" href="{{ route('alumnado') }}">Ver Alumnado</a>
@endsection
