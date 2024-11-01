@extends('adminlte::page')

@section('title', 'Agregar numero_lote')

@section('content_header')
<h2 class="text-center">Editar Lote</h2>
<hr>
@stop

@section('content')
<form action="{{ url('/admin/almacen/almacen/'.$almacen->id_inventario) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}

  <div class="form-group">
    <label for="Nombre" class="control-label">{{ 'Nombre' }}</label>
    <select name="id_medicamento" id="medicamentoSelect">
      <option value="">Seleccione un medicamento</option>
      @foreach ($Medicamentos as $Medicamento)
      <option value="{{ $Medicamento['id_medicamento'] }}"
        {{ $almacen->id_medicamento == $Medicamento['id_medicamento'] ? 'selected' : '' }}>
        {{ $Medicamento['nombre'].' - '.$Medicamento['fabricante'] }}
      </option>
      @endforeach
    </select>
    {!! $errors->first('Nombre', '<div class="invalid-feedback">:message</div>') !!}
    <div class="invalid-feedback"></div>
  </div>

  <div class="form-group">
    <label for="fecha_vencimiento" class="control-label">{{ 'Fecha de Vencimiento' }}</label>
    <input type="date" class="form-control {{ $errors->has('fecha_vencimiento') ? 'is-invalid' : '' }}"
      name="fecha_vencimiento" id="fecha_vencimiento"
      value="{{ old('fecha_vencimiento', $almacen->fecha_vencimiento) }}">
    {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
    <div class="invalid-feedback"></div>
  </div>

  <div class="form-group">
    <label for="numero_lote" class="control-label">{{ 'Número de Lote' }}</label>
    <input type="text" class="form-control {{ $errors->has('numero_lote') ? 'is-invalid' : '' }}"
      name="numero_lote" id="numero_lote"
      value="{{ old('numero_lote', $almacen->numero_lote) }}">
    {!! $errors->first('numero_lote', '<div class="invalid-feedback">:message</div>') !!}
    <div class="invalid-feedback"></div>
  </div>

  <div class="form-group">
    <label for="cantidad_disponible" class="control-label">{{ 'Cantidad Disponible' }}</label>
    <input type="number" class="form-control {{ $errors->has('cantidad_disponible') ? 'is-invalid' : '' }}"
      name="cantidad_disponible" id="cantidad_disponible"
      value="{{ old('cantidad_disponible', $almacen->cantidad_disponible) }}">
    {!! $errors->first('cantidad_disponible', '<div class="invalid-feedback">:message</div>') !!}
    <div class="invalid-feedback"></div>
  </div>

  <div class="form-group" style="display: none;">
    <label for="id_farmacia" class="control-label">{{ 'ID Farmacia' }}</label>
    <input type="text" class="form-control {{$errors->has('id_farmacia')?'is-invalid':''}}"
      name="id_farmacia" id="id_farmacia"
      value="{{ Auth::user()->farmacias->first()->id_farmacia ?? '' }}">
  </div>

  <input type="submit" class="btn btn-success" value="{{ 'Editar' }}">
  <a class="btn btn-secondary" href="{{ url('admin/almacen/almacen') }}">Regresar</a>
</form>


<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">



@stop

@section('css')

@stop

@section('js')

@stop