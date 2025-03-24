@extends('layouts.login')

@section('title', 'Regsitro')

@section('content')
<form id="registroProfesorForm" method="POST" action="{{ route('registro') }}">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @csrf
    <div class="form-group">
        <label for="nombre">Código de profesor</label>
        <input type="text" class="form-control" id="nombre" value="{{old('nombre')}}" name="nombre" required>
    </div>
    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" name="password" id="pass" required>
    </div>
    <div class="form-group">
        <label for="confirmPassword">Confirma tu contraseña</label>
        <input type="password" class="form-control" name="password_confirmation" id="pass2" required>
    </div>
    <div>
        <button type="submit" class="btn  btn-warning text-light" form="registroProfesorForm">Completar
            Registro</button>
    </div>
</form>
@endsection