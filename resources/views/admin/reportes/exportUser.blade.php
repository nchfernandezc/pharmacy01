@extends('adminlte::page')

@section('title', 'Medicamentos Reportes')

@section('content_header')
<h2 class="text-center">Clientes</h2>
<hr>
<a class="btn btn-success" href="{{ route('exportUser.pdfUser', ['busqueda' => $busqueda]) }}" target="_blank">Descargar reporte</a>

<form action="{{ url('admin/reportes/exportUser') }}" style="display:inline" method="get">
    <div class="btn-group">
        <input type="text" name="busqueda" class="form-control" placeholder="Buscar usuario" value="{{ old('busqueda', $busqueda) }}">
        <input type="submit" value="Buscar" class="btn btn-primary">
    </div>
</form>
@stop

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-light">
    <thead class="thead-light w-100">
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $usuario)
        <tr>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->apellido }}</td>
            <td>{{ $usuario->cedula }}</td>
            <td>{{ $usuario->telefono }}</td>
            <td>{{ $usuario->email }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">
<link rel="stylesheet" href="{{ asset('/build/assets/admin/index.css') }}">
@stop

@section('js')

@stop
