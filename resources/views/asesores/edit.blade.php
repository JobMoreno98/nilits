@extends('layouts.layout')

@section('title', 'Editar asesor')

@section('content')
    <div class="contaner">
        <h2 class="text-uppercase text-center">Editar asesor</h2>
        @if ($errors->any())
            <div class="row">
                <div class="alert alert-danger col-sm-10">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <form method="POST" class="d-flex flex-wrap justify-content-around"
            action="{{ route('/maestros/update/', ['codigo' => $asesor->codigo]) }}">

            @csrf
            @method('PUT')
            <div class="form-group col-md-3 col-sm-12">
                <label for="codigo">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $asesor->codigo }}"
                    readonly>
            </div>
            <div class="form-group  col-md-4 col-sm-12">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre" required
                    value="{{ $asesor->Nombre }}">
            </div>
            <div class="form-group  col-md-4 col-sm-12">
                <label for="Apellido">Apellidos</label>
                <input type="text" class="form-control" id="Apellido" name="Apellido" required
                    value="{{ $asesor->Apellido }}">
            </div>
            <div class="form-group  col-md-3 col-sm-12">
                <label for="correo">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="{{ $asesor->correo }}">
            </div>
            <div class="form-group  col-md-3 col-sm-12">
                <label for="correo">Telefono fijo</label>
                <input type="text" class="form-control" id="telefonoFijo" name="telefonoFijo"
                    value="{{ $asesor->telefonoFijo }}">
            </div>
            <div class="form-group  col-md-3 col-sm-12">
                <label for="correo">Telefono celular</label>
                <input type="text" class="form-control" id="telCel" name="telCel" value="{{ $asesor->telCel }}">
            </div>

            <div class="form-group  col-md-2 col-sm-12">
                <label for="correo">Extencion</label>
                <input type="number" class="form-control" id="telExt" name="telExt" value="{{ $asesor->telExt }}">
            </div>

            <div class="form-group  col-md-4 col-sm-12">
                <label for="nombramiento">Nombramiento</label>
                <input type="text" class="form-control" id="nombramiento" name="nombramiento"
                    value="{{ $asesor->nombramiento }}">
            </div>
            <div class="form-group  col-md-2 col-sm-12">
                <label for="cargaHoraria">Carga horaria</label>
                <input type="text" class="form-control" id="cargaHoraria" name="cargaHoraria"
                    value="{{ $asesor->cargaHoraria }}">
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for="correo">Adscripcion</label>
                <input type="text" class="form-control" id="adscripcion" name="adscripcion"
                    value="{{ $asesor->adscripcion }}">
            </div>
            <div class="form-group col-md-2 col-sm-12">
                <label for="correo">Grado</label>
                <input type="text" class="form-control" id="grado" name="grado" value="{{ $asesor->grado }}">
            </div>
            <div class="form-group col-md-12 mx-1 col-sm-12">
                <label for="correo">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control w-100">{{ $asesor->observaciones }}</textarea>
            </div>
            <div class="col-sm-auto text-center my-2">
                <a href="{{ route('asesores') }}" class="btn btn-secondary text-uppercase btn-sm">cancelar</a>
                <button type="submit" class="btn btn-primary text-uppercase btn-sm">Guardar Cambios</button>
            </div>
        </form>
    </div>
@endsection
