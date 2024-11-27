@extends('layouts.layout')

@section('title', 'Editar Usuario')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3 class="text-uppercase text-center mt-2">Usuario {{ $usuario->nombre }}</h3>
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="post" class="d-flex flex-column align-items-center">
        @csrf
        @method('PUT')
        <div class="col-sm-12 col-md-4 m-1">
            <label for="">Código</label>
            <input class="form-control" type="text" readonly value="{{ $usuario->nombre }}" name="nombre">
        </div>
        <div class="col-sm-12 col-md-4 m-1">
            <label for="">Rol</label>
            <select name="role" id="" class="form-control">
                @foreach ($roles as $item)
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success btn-sm col-sm-12 col-md-1 m-1">Guardar</button>
    </form>
@endsection
