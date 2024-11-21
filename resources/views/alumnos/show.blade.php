@extends('layouts.layout')

@section('title', 'Ver Alumno')

@section('content')

    <div class="container">
        <form method="POST" action="{{ route('/alumnos/update/', $alumno->codigo) }}" id="formularioData">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @method('PUT')
            <div class="modal-body d-flex flex-wrap">
                <!-- Campos del formulario -->
                <div class="form-group mx-1 col-sm-12 col-md-2">
                    <label for="codigo">Código</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $alumno->codigo }}"
                        required>
                </div>
                <div class="form-group mx-1 col-sm-12 col-md-5">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $alumno->Nombre }}"
                        required>
                </div>

                <div class="form-group mx-1 col-sm-12 col-md-4">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control" id="correo" value="{{ $alumno->correo }}" name="correo">
                </div>

                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" value="{{ $alumno->telefono }}"
                        name="telefono">
                </div>
                <div class="form-group mx-1 col-sm-12 col-md-2">
                    <label for="genero">Genero</label>
                    <select class="form-control" id="genero" name="genero">
                        <option {{ strcmp($alumno->genero, 'Masculino') == 0 ? 'selected' : '' }} value="Masculino">
                            Masculino
                        </option>
                        <option {{ strcmp($alumno->genero, 'Femenino') == 0 ? 'selected' : '' }} value="Femenino">Femenino
                        </option>
                    </select>
                </div>

                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="procedencia">Procedencia</label>
                    <select class="form-control" name="procedencia" id="procedencia">
                        <option value="0">Aguascalientes</option>
                        <option value="1">Baja California</option>
                        <option value="2">Baja California Sur</option>
                        <option value="3">Campeche</option>
                        <option value="4">Chiapas</option>
                        <option value="5">Chihuahua</option>
                        <option value="6">Ciudad de México</option>
                        <option value="7">Coahuila</option>
                        <option value="8">Colima</option>
                        <option value="9">Durango</option>
                        <option value="10">Guanajuato</option>
                        <option value="11">Guerrero</option>
                        <option value="12">Hidalgo</option>
                        <option value="13">Jalisco</option>
                        <option value="14">México</option>
                        <option value="15">Michoacán</option>
                        <option value="16">Morelos</option>
                        <option value="17">Nayarit</option>
                        <option value="18">Nuevo León</option>
                        <option value="19">Oaxaca</option>
                        <option value="20">Puebla</option>
                        <option value="21">Querétaro</option>
                        <option value="22">Quintana Roo</option>
                        <option value="23">San Luis Potosí</option>
                        <option value="24">Sinaloa</option>
                        <option value="25">Sonora</option>
                        <option value="26">Tabasco</option>
                        <option value="27">Tamaulipas</option>
                        <option value="28">Tlaxcala</option>
                        <option value="29">Veracruz</option>
                        <option value="30">Yucatán</option>
                        <option value="31">Zacatecas</option>
                    </select>
                </div>
                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="fechaNac">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fechaNac" value="{{ $alumno->fechaNac }}"
                        name="fechaNac">
                </div>
                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="telefono">Calendario de Ingreso</label>
                    <select class="form-control" name="ingreso" id="ingreso">
                        <option value="{{ $alumno->ingreso }}" selected>{{ $alumno->ingreso }}</option>
                        @php
                            $startYear = 1990;
                            $endYear = date('Y');
                        @endphp
                        @for ($year = $startYear; $year <= $endYear; $year++)
                            <option value="{{ $year }} A">{{ $year }} A</option>
                            <option value="{{ $year }} B">{{ $year }} B</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="egreso">Calendario de Egreso</label>
                    <select class="form-control" name="calendarioTitulacion" id="calendarioTitulacion">
                        <option value="{{ $alumno->calendarioTitulacion }}" selected>{{ $alumno->calendarioTitulacion }}
                        </option>
                        @php
                            $startYear = isset($alumno->ingreso) ? 1990 : explode(' ', $alumno->ingreso)[0];
                            $endYear = date('Y');
                        @endphp
                        @for ($year = $startYear; $year <= $endYear; $year++)
                            <option value="{{ $year }} A">{{ $year }} A</option>
                            <option value="{{ $year }} B">{{ $year }} B</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="opcionTitulacion">Opción de Titulacion</label>
                    <input type="text" class="form-control" id="opcionTitulacion" name="opcionTitulacion">
                </div>

                <div class="form-group mx-1 col-sm-12 col-md-2">
                    <label for="estatus">Estatus</label>
                    <select class="form-control" id="estatus" name="estatus">
                        <option {{ $alumno->estatus == 1 ? 'selected' : '' }} value="1">Activo</option>
                        <option {{ $alumno->estatus == 4 ? 'selected' : '' }} value="3">Egresado</option>
                        <option {{ $alumno->estatus == 3 ? 'selected' : '' }} value="4">Baja</option>
                    </select>
                </div>
                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="fechaTitulacion">Fecha de titulacion</label>
                    <input type="date" class="form-control" id="fechaTitulacion"
                        value="{{ $alumno->fechaTitulacion }}" name="fechaTitulacion">
                </div>

                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="acta">Acta</label>
                    <input type="text" class="form-control" id="acta" value="{{ $alumno->acta }}"
                        name="acta">
                </div>
                <div class="form-group mx-1 col-sm-12 col-md-3">
                    <label for="libro">Libro</label>
                    <input type="text" class="form-control" id="libro" value="{{ $alumno->libro }}"
                        name="libro">
                </div>

                <div class="col-sm-12">
                    <div class="form-group mx-1 d-flex flex-column">
                        <h4><label for="dictamen">Dictámenes</label></h4>

                        <div class="col-md-3 mx-1">
                            <p>Listado de dictamenes</p>
                            <input type="text" class="form-control " id="dictamenInput" name="dictamen[]"
                                placeholder="Añadir dictamen">
                        </div>
                        <div id="formulario" class="col-md-3">

                        </div>
                    </div>
                </div>
            </div>
            @can('Alumnos#editar')
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mx-1">Guardar Cambios</button>
                </div>
            @endcan

        </form>
    </div>

@endsection
@section('scripts')
    <script>
        function eliminar(eliminar) {
            let elemento = document.getElementById(eliminar);
            elemento.parentNode.removeChild(elemento);
        }
        $(document).ready(function() {
            let elemento = document.getElementById('formulario');
            elemento.innerHTML = '';

            var cont = 0;
            var dictamen = "{{ $alumno->dictamen }}";
            dictamen = dictamen.split('.').filter(function(letter) {
                return letter !== '';
            });


            let form = document.getElementById('formulario');
            let arreglo = ['dictamen[]'];

            dictamen.forEach(function(element) {
                if (element !== '') {
                    var div = document.createElement("div");
                    div.setAttribute('id', cont);
                    div.className = 'input-group d-flex flex-wrap';

                    var span = document.createElement("span");
                    span.className = "btn btn-danger";
                    span.className = "btn btn-danger m-1";
                    span.textContent = 'X';
                    let numero = cont;

                    span.addEventListener("click", function() {
                        eliminar(numero)
                    }, false);

                    var input = document.createElement("input");
                    input.name = 'dictamen[]';
                    input.className = "form-control col-md-3 m-1";
                    input.readOnly = true;
                    input.value = element;
                    div.appendChild(input);
                    cont = cont + 1;
                    div.appendChild(span);
                    form.appendChild(div);
                }
            });

        });
    </script>
@endsection
