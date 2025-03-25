@extends('layouts.layout')

@section('title', 'Gestionar Alumnos')

@section('styles')
    <style>
        @media(min-width:1200px) {
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f7f7f7;
            }

        }

        .form-control {
            margin-bottom: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex w-100 h-100 align-items-center " style="min-height: 85vh">
        <div class="d-none d-xl-block  col-xl-8 me-xl-2 h-100"
            style="background: url('{{ asset('imgs/aspirante.jpg') }}');  background-repeat: no-repeat;  background-position: 0% 0%;background-size: 100% 100%;">
        </div>
        <div class="w-100 p-3 m-auto">
            <form method="POST" action="{{ route('aspirantes.store') }}">
                @csrf
                <!-- Código -->
                <div class="form-group">
                    <label for="codigo">Folio de Aspirante</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" value="{{ old('codigo') }}"
                        required>
                </div>

                <!-- Nombre -->
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" name="nombre" class="form-control" id="Nombre" value="{{ old('nombre') }}" required>
                </div>

                <!-- Teléfono -->
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" id="telefono" pattern="[0-9]*" value="{{ old('telefono') }}">
                </div>

                <!-- Correo -->
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" class="form-control" id="correo" value="{{ old('correo') }}">
                </div>

                <!-- Género -->
                <div class="form-group">
                    <label for="genero">Género</label>
                    <select class="form-control" name="sexo" id="sexo" value="{{ old('sexo') }}">
                        <option selected disabled>Elegir</option>
                        <option value="0">Masculino</option>
                        <option value="1">Femenino</option>
                    </select>
                </div>
                <!-- Procedencia -->
                <div class="form-group mx-1 col-sm-12">
                    <label for="procedencia">Procedencia</label>
                    <select class="form-control" name="procedencia" id="procedencia" value="{{ old('procedencia') }}">
                        <option disabled selected>Elegir..</option>
                        @foreach ($estados as $key => $value)
                            <option value="{{ $value }}">
                                {{ $key + 1 . '-' . $value }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Fecha de Nacimiento -->
                <div class="form-group">
                    <label for="fechaNac">Fecha de Nacimiento</label>
                    <input type="date" name="fechaNac" class="form-control" id="fechaNac" value="{{ old('fechaNac') }}">
                </div>
                <button type="submit" class="btn btn-primary">Crear registro</button>
            </form>
        </div>

    </div>
@endsection
