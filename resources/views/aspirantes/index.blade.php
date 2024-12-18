@extends('layouts/layout')
@section('title', 'Gestionar Alumnos')
@section('content')
    <div class="container mt-5 p-0">
        <h2 class="mb-4 text-light" style="background-color: rgb(82, 82, 255)">Aspirantes</h2>
        <div>
            <img src="{{ asset('imgs/aspirante.jpg') }}" alt="" style="border: 5px ;height: 200px; width: 1080px;">

            <h1>Bienvenido</h1>
        </div>
        <br>
        <div>¡Regístrate!</div>
        <br><br><br><br>




        <!-- Botones de acción -->
        <div class="text-center">
            <button class="btn text-light" style="background-color: rgb(0, 0, 169)" type="button" data-bs-toggle="modal"
                data-bs-target="#agregar">Registrar
                Aspirante</button>
            <a href="{{ route('/home') }}" class="btn btn-secondary">Volver al menu</a>
        </div>
    </div>


    {{-- Aqui empieza el modal  REGISTRAR ASPIRANTES --}}
    <div class="modal fade" id="agregar" tabindex="-1" aria-labelledby="agregar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí empieza el formulario -->
                    <form method="POST" action="{{ route('aspirantes.store') }}">
                        @csrf
                        <!-- Código -->
                        <div class="form-group">
                            <label for="codigo">Folio de Aspirante</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" required>
                        </div>

                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" name="nombre" class="form-control" id="Nombre" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" id="telefono" pattern="[0-9]*">
                        </div>

                        <!-- Correo -->
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" name="correo" class="form-control" id="correo">
                        </div>

                        <!-- Género -->
                        <div class="form-group">
                            <label for="genero">Genero</label>
                            <select class="form-control" name="sexo" id="sexo">
                                <option value="0">Masculino</option>
                                <option value="1">Femenino</option>
                            </select>
                        </div>
                        <!-- Procedencia -->
                        <div class="form-group">
                            <label for="procedencia">Procedencia</label>
                            <select class="form-control" name="procedencia">
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
                        <!-- Fecha de Nacimiento -->
                        <div class="form-group">
                            <label for="fechaNac">Fecha de Nacimiento</label>
                            <input type="date" name="fechaNac" class="form-control" id="fechaNac">
                        </div>
                        <button type="submit" class="btn btn-primary">Crear registro</button>
                    </form>


                    <!-- Aquí termina el formulario -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>



@endsection
