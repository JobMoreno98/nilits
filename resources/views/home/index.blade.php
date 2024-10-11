@extends('layouts.layout')
@section('title', 'Home')
@section('content')
    <div class="container mt-5">
        <!-- Subtítulo -->
        <h2 class="text-secondary text-center">Nivelación a la Licenciatura en Trabajo Social - CUCSH</h2>

        <!-- Tarjetas de Opciones -->
        <div class="d-flex flex-wrap text-center justify-content-center">
            <!-- Tarjeta Alumnos -->

            <div class="col-md-3 mb-4">
                <a href="{{ route('alumnos') }}" style="color: black; font-family: arial; text-decoration: none ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Alumnos</h5>
                            <i class="fas fa-user-graduate" style="font-size: 50px;"></i>
                            <p class="card-text">Gestión de los datos de los alumnos</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta Asesores -->
            <div class="col-md-3 mb-4 mx-2">
                <a href="{{ route('asesores') }}" style="color: black; font-family: arial; text-decoration: none ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Asesores</h5>
                            <i class="fas fa-chalkboard-teacher" style="font-size: 50px;"></i>
                            <p class="card-text">Gestión de los datos de los asesores</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Tarjeta Tutores -->

            <div class="col-md-3 mb-4">
                <a href="{{ route('gestionar-tutores') }}" style="color: black; font-family: arial; text-decoration: none ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Tutores</h5>
                            <i class="fas fa-book-reader" style="font-size: 50px;"></i>
                            <p class="card-text">Asignación de Tutores</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta Numeralia -->
            <div class="col-md-3 mb-4 ">
                <a href="{{ route('numeralia') }}" style="color: black; font-family: arial; text-decoration: none ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Numeralia</h5>
                            <i class="fas fa-database" style="font-size: 50px;"></i>
                            <p class="card-text">Reportes de datos</p>
                        </div>
                    </div>
            </div>
            <!-- Tarjeta Aspirantes -->
            <div class="col-md-3 mb-4 mx-2">
                <a href="{{ route('aspirante') }}" style="color: black; font-family: arial; text-decoration: none ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Aspirantes</h5>
                            <i class="fas fa-user-circle" style="font-size: 60px;"></i>
                            <p class="card-text">Gestión de Aspirantes</p>
                        </div>
                    </div>
            </div>
            <!-- Tarjeta Normatividad -->
            <div class="col-md-3 mb-4">
                <a href="{{ route('normatividad') }}" style="color: black; font-family: arial; text-decoration: none ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Normatividad</h5>
                            <i class="fas fa-book" style="font-size: 60px;"></i>
                            <p class="card-text">Documentación CUCSH</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
@endsection
