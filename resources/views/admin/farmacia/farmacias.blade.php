@extends('adminlte::page')

@section('title', 'Farmacias')

@section('content_header')
<h1 class="text-center">Farmacia</h1>
<hr>
@stop

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @foreach($farmacias as $farmacia)
        <div class="card mb-3" style="max-width: 100%;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('storage').'/'.$farmacia->imagen }}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $farmacia->nombre_razon_social }}</h5>
                        <p class="card-text">{{ $farmacia->descripcion }}</p>
                        <p class="card-text"><small class="text-muted">J-{{ $farmacia->rif }}</small></p>
                        <a class="btn btn-success" href="{{ url('admin/farmacia/farmacias/'.$farmacia->id_farmacia.'/edit') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@stop

@section('css')
{{-- --}}
<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">

@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#miModal').modal('show');
    });
    $(document).on('click', function() {
        $('#gg').modal('hide');
    });
</script>
@stop
