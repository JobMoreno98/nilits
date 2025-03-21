@extends('layouts.layout')

@section('title', 'Editar asesor')

@section('content')
    <div class="container">
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
            action="{{ Auth::user()->hasRole('admin') ? route('/maestros/update/', ['codigo' => $asesor->codigo]) : '' }}">
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
                    value="{{ $asesor->nombre }}">
            </div>
            <div class="form-group  col-md-4 col-sm-12">
                <label for="Apellido">Apellidos</label>
                <input type="text" class="form-control" id="Apellido" name="Apellido" required
                    value="{{ $asesor->apellido }}">
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
            <div class="form-group col-md-12  col-sm-12">
                <label for="correo">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control w-100">{{ $asesor->observaciones }}</textarea>
            </div>

            <div class="col-sm-auto text-center my-2">
                <a href="{{ route('asesores') }}" class="btn btn-secondary text-uppercase btn-sm">cancelar</a>
                @if (Auth::user()->hasRole('admin'))
                    <button type="submit" class="btn btn-primary text-uppercase btn-sm">Guardar Cambios</button>
                @endif
            </div>

        </form>
        @if (Auth::user()->hasRole('admin'))
            <div class="text-center">
                <a class="btn btn-danger text-uppercase btn-sm" href="{{ route('asesor.delete', $asesor->id) }}"
                    onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                    eliminar
                </a>

                <form id="delete-form" action="{{ route('asesor.delete', $asesor->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('PUT')
                </form>
            </div>
        @endif
        <ul class="nav nav-tabs text-center" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="tutorados-tab" data-bs-toggle="tab" data-bs-target="#tutorados-tab-pane"
                    type="button" role="tab" aria-controls="tutorados-tab-pane" aria-selected="true">Tutorados
                    asignados</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Asignar
                    Tutorados</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show " id="tutorados-tab-pane" role="tabpanel" aria-labelledby="tutorados-tab"
                tabindex="0">
                <form action="{{ route('asigandos-alumnos', $asesor->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="d-flex flex-wrap align-items-center justify-content-around">
                        @forelse  ($asesor->tutorados as $item)
                            <div class="form-check m-1 col-sm-12 col-md-2  p-2 form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                    name="alumnos[]" id="flexCheckDefault" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $item->Nombre }}
                                </label>
                            </div>
                        @empty
                            <p class="mt-2">Sin alumnos asigandos</p>
                        @endforelse
                    </div>
                    @if (Auth::user()->hasRole('admin'))
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-success">Guardar tutorados</button>
                        </div>
                    @endif
                </form>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <form action="{{ route('asignar-alumnos', $asesor->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="d-flex flex-wrap align-items-center justify-content-around">
                        @php
                            $estatusPosibles = [
                                '1' => '<b class="text-success">Activo</b>',
                                '3' => '<b class="text-warning">Egresado</b>',
                                '4' => '<b class="text-danger">Baja</b>',
                            ];
                        @endphp
                        @forelse  ($alumnos_sin_asesor as $item)
                            <div class="form-check m-1 col-sm-12 col-md-2  p-2 form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                    name="alumnos[]" id="{{ $item->id }}">

                                <label class="form-check-label" for="{{ $item->id }}">
                                    <b>Nombre:</b> {{ $item->nombre_alumno }} <br>
                                    <b>Estatus:</b> {!! $estatusPosibles[$item->estatus] !!}
                                </label>
                            </div>
                        @empty
                            <p class="mt-2">Sin alumnos asigandos</p>
                        @endforelse
                    </div>
                    @if (Auth::user()->hasRole('admin'))
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-success">Guardar tutorados</button>
                        </div>
                    @endif
                </form>
            </div>

        </div>
    </div>
@endsection
