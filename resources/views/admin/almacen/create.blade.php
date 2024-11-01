@extends('adminlte::page')

@section('title', 'Agregar numero_lote')

@section('content_header')
<h2 class="text-center">Agregar Lote</h2>
<hr>
@stop

@section('content')
<form action="{{ route('almacen.store')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="Nombre" class="control-label">{{ 'Nombre' }}</label>
        <select name="id_medicamento" id="medicamentoSelect">
            <option value="">Seleccione un medicamento</option>
            @foreach ($Medicamentos as $Medicamento)
            <option value="{{ $Medicamento['id_medicamento'] }}">{{ $Medicamento['nombre'].' - '.$Medicamento['fabricante'] }}</option>
            @endforeach
        </select>
        {!! $errors->first('Nombre', '<div class="invalid-feedback">:message</div>') !!}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label for="fecha_vencimiento" class="control-label">{{ 'fecha_vencimiento' }}</label>
        <input type="date" class="form-control {{ $errors->has('fecha_vencimiento') ? 'is-invalid' : '' }}" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}">
        {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label for="numero_lote" class="control-label">{{ 'numero de lote' }}</label>
        <input type="text" class="form-control {{ $errors->has('numero_lote') ? 'is-invalid' : '' }}" name="numero_lote" id="numero_lote" value="{{ old('numero_lote') }}">
        {!! $errors->first('numero_lote', '<div class="invalid-feedback">:message</div>') !!}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label for="cantidad_disponible" class="control-label">{{ 'cantidad disponible' }}</label>
        <input type="number" class="form-control {{ $errors->has('cantidad_disponible') ? 'is-invalid' : '' }}" name="cantidad_disponible" id="cantidad_disponible" value="{{ old('cantidad_disponible') }}">
        {!! $errors->first('cantidad_disponible', '<div class="invalid-feedback">:message</div>') !!}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group" style="display: none;">
        <label for="id_farmacia" class="control-label">{{'id_farmacia'}}</label>
        <input type="text" class="form-control {{$errors->has('id_farmacia')?'is-invalid':''}}" name="id_farmacia" id="id_farmacia" value="{{ Auth::user()->farmacias->first()->id_farmacia ?? '' }}">
    </div>

    <input type="submit" class="btn btn-success" value="{{ 'Agregar' }}">
    <a class="btn btn-secondary" href="{{ url('admin/almacen/almacen') }}">Regresar</a>
</form>

<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">



@stop

@section('css')
<style>
    #medicamentoSelect {
        width: 100%;
        font-size: 1rem;
        text-align: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 18px;
    }
</style>

@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#medicamentoSelect').select2({
            placeholder: "Seleccione un medicamento",
            allowClear: true
        });
    });
</script>
@stop