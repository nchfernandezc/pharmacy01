@extends('layouts1.user')

@section('title', 'Home - Sistema de Medicinas')

@section('content')

    <div class="col-md-9 no-padding">

        <!-- Search Bar
        <div class="input__container input__container--variant">
            <div class="shadow__input shadow__input--variant"></div>
            <input type="text" name="text" class="input__search input__search--variant" placeholder="Buscar...">
            <button class="input__button__shadow input__button__shadow--variant">
                <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="1.5em" width="1.5em">
                    <path d="M4 9a5 5 0 1110 0A5 5 0 014 9zm5-7a7 7 0 104.2 12.6.999.999 0 00.093.107l3 3a1 1 0 001.414-1.414l-3-3a.999.999 0 00-.107-.093A7 7 0 009 2z" fill-rule="evenodd" fill="#FFF"></path>
                </svg>
            </button>
        </div>
         -->
    </div>


    <h1 style="text-align: center">Resultados de la Búsqueda</h1>
    <hr>

    @if($medicamentos->isEmpty())
        <p>No se encontraron medicamentos.</p>
    @else
        <div class="row">
            @foreach($medicamentos as $medicamento)
                <div class="col-md-3 mb-4 product-item">
                    <div class="product-card shadow-sm">
                        <div class="product-img-container">
                            @if($medicamento->Foto)
                                <img src="{{asset('storage').'/'.$medicamento->Foto}}" alt="{{ $medicamento->nombre }}" class="product-img card-img-top">
                            @else
                                <img src="https://via.placeholder.com/300x300?text={{ $medicamento->nombre }}" alt="Sin Imagen" class="product-img card-img-top">
                            @endif
                            <div class="product-actions">
                                <button class="btn-common btn-circle btn-heart add-to-wishlist" data-id="{{ $medicamento->id_medicamento }}">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <button class="btn-common btn-circle btn-cart add-to-cart-btn" data-id="{{ $medicamento->id_medicamento }}" data-cantidad="1">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h6>
                                <a href="#" class="product-link" data-bs-toggle="modal" data-bs-target="#medicamentoModal"
                                    data-id="{{ $medicamento->id_medicamento }}"
                                    data-nombre="{{ $medicamento->nombre }}"
                                    data-precio="{{ $medicamento->precio }}"
                                    data-descripcion="{{ $medicamento->descripcion }}"
                                    data-image-path="{{ $medicamento->Foto ? asset('storage').'/'.$medicamento->Foto : 'https://via.placeholder.com/300x300?text='.$medicamento->nombre }}"
                                    data-pais="{{ $medicamento->pais_fabricacion }}"
                                    data-categoria="{{ $medicamento->categoria }}"
                                    data-farmacia="{{ $medicamento->farmacia->nombre_razon_social }}">
                                    {{ $medicamento->nombre }}
                                </a>
                            </h6>
                            <p>${{ number_format($medicamento->precio, 2) }}</p>
                            <p>{{ $medicamento->farmacia->nombre_razon_social }}</p>
                            <p>Distancia: {{ $medicamento->distance }} km</p>
                        </div>
                        <!-- Hidden inputs for id_medicamento and cantidad -->
                        <input type="hidden" class="id_medicamento" value="{{ $medicamento->id_medicamento }}">
                        <input type="hidden" class="cantidad" value="1">
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{url ('user/home')}}">
        <button class="btn-regresar">
            <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4
                                6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32
                                32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32
                                32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0
                                128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
            <div class="text">Regresar</div>
        </button>
    </a>
    <br>


    <!-- Modal para mostrar detalles del medicamento -->
    <div class="modal fade" id="medicamentoModal" tabindex="-1" aria-labelledby="medicamentoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medicamentoModalLabel" style="text-align: center; width: 100%;">
                        Detalles del Medicamento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="medicamentoImage" src="" alt="Imagen del Medicamento" class="img-fluid mb-3" style="max-height: 300px;">
                    <h5 id="medicamentoNombre"></h5>
                    <hr>
                    <p><strong>Precio:</strong> $<span id="medicamentoPrecio"></span></p>
                    <p><strong>Descripción:</strong> <span id="medicamentoDescripcion"></span></p>
                    <p><strong>País de Fabricación:</strong> <span id="medicamentoPais"></span></p>
                    <p><strong>Categoría:</strong> <span id="medicamentoCategoria"></span></p>
                    <hr>
                    <p><strong>Se encuentra en:</strong> <span id="medicamentoFarmacia"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
