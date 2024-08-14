@extends('layouts.layout')

@section('content')
    <h3 class="text-uppercase text-center">usuarios</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $item)
                <tr>
                    <td>{{ $item->nombre }}</td>
                    <td class="text-uppercase">{{ $item->getRoleNames()}}</td>
                    <td><a href="{{ route('usuarios.edit', $item->id) }}"> <i class="text-dark fas fa-edit"
                                role="button"></i></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
