@extends('layouts1.user')

@section('title', 'Perfil - Sistema de Medicinas')

@section('content')
    <div class="container-custom profile-container-custom mt-4">
        <div class="profile-header">
            <h2>Perfil</h2>
            <p class="text-center mt-2">Actualiza tu información de perfil</p>
            <hr>
        </div>

        <div class="profile-content">
            <form class="profile-form" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3 position-relative">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control profile-input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                    <div class="alert alert-danger mb-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control profile-input" id="apellido" name="apellido" value="{{ old('apellido', $user->apellido) }}" required>
                    @error('apellido')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="cedula" class="form-label">Cédula</label>
                    <input type="text" class="form-control profile-input" id="cedula" name="cedula" value="{{ old('cedula', $user->cedula) }}" required>
                    @error('cedula')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control profile-input" id="telefono" name="telefono" value="{{ old('telefono', $user->telefono) }}" required>
                    @error('telefono')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control profile-input" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2 text-gray-800">
                            {{ __('Tu dirección de correo electrónico no está verificada.') }}
                            <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Haz clic aquí para reenviar el correo de verificación.') }}</button>
                            </form>
                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success mt-2">
                                    {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-custom">Guardar Cambios</button>
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success mt-2">
                        {{ __('Guardado.') }}
                    </div>
                @endif
            </form>
            <hr>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addressModal">
                    Ver direcciones
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addressModalLabel">Direcciones Guardadas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 position-relative">
                                <div id="addressList">
                                    @forelse(auth()->user()->addresses as $address)
                                        <div class="address-item mb-3 d-flex justify-content-between align-items-center" data-address-id="{{ $address->id }}">
                                            <span>{{ $address->name }}</span>
                                            <button class="bin-button" onclick="event.preventDefault(); document.getElementById('delete-address-{{ $address->id }}').submit();">
                                                <svg class="bin-top" viewBox="0 0 39 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <line y1="5" x2="39" y2="5" stroke="white" stroke-width="4"></line>
                                                    <line x1="12" y1="1.5" x2="26.0357" y2="1.5" stroke="white" stroke-width="3"></line>
                                                </svg>
                                                <svg class="bin-bottom" viewBox="0 0 33 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <mask id="path-1-inside-1_8_19" fill="white">
                                                        <path d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"></path>
                                                    </mask>
                                                    <path d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z" fill="white" mask="url(#path-1-inside-1_8_19)"></path>
                                                    <path d="M12 6L12 29" stroke="white" stroke-width="4"></path>
                                                    <path d="M21 6V29" stroke="white" stroke-width="4"></path>
                                                </svg>
                                            </button>
                                            <form id="delete-address-{{ $address->id }}" action="{{ route('addresses.destroy', $address->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                        <hr>
                                    @empty
                                        <p>No tienes direcciones guardadas.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center mt-4">
                <a href="{{ route('user.configuracion') }}">
                    <button class="btn btn-custom">Agregar direcciones</button>
                </a>
            </div>
        </div>
    </div>

    <div class="container-custom profile-container-custom password-container-custom mt-4">
        <div class="profile-header">
            <h2>Actualizar Contraseña</h2>
            <p class="text-center mt-2">Asegúrate de usar una contraseña segura</p>
            <hr>
        </div>
        <div class="profile-content">
            <form class="password-form" method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="mb-3 position-relative">
                    <label for="current_password" class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-control password-input" id="current_password" name="current_password" required>
                    @error('current_password', 'updatePassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 position-relative">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control password-input" id="new_password" name="password" required>
                    @error('password', 'updatePassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 position-relative">
                    <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control password-input" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation', 'updatePassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-custom">Actualizar Contraseña</button>
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success mt-2">
                        {{ __('Guardado.') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
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
@endsection
