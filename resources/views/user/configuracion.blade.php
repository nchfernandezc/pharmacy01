<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario</title>
    <!-- Incluir CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Incluir CSS de Leaflet GeoSearch -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <link href="{{ asset('build/assets/css/styles.css') }}" rel="stylesheet">
    <style>
        #map {
            height: 200px;
            /* Ajusta la altura del mapa */
            width: 100%;
        }

        /* Estilo para las sugerencias */
        #suggestions {
            position: absolute;
            top: 280px;
            left: 20%;
            width: 60%;
            max-height: 200px;
            overflow-y: auto;
            background-color: rgba(255, 255, 255, 0.698);
            border: transparent;
            z-index: 1000;
        }

        #suggestions div {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
        }

        #suggestions div:hover {
            background-color: #f0f0f0;
        }
        @media (max-width: 768px) {
            .custom-container {
                padding: 15px;
                max-width: 90%;
            }
        }
    </style>
</head>

<body>

    @include(('user.partials.preloader'))

    <div class="custom-container" id="container">
        <div class="logo-container text-center" style="text-align: center;">
            <img src="{{ asset('build/assets/images/logo_app.svg') }}" alt="Logo de la aplicación" class="img-fluid" style="max-width: 125px; display: block; margin: 0 auto;">
        </div>
        <div class="custom-form-container">
            <h1>Configura la Dirección</h1>
            <hr>
            <form class="custom-form" method="POST" action="{{ route('guardarDireccion') }}">
                @csrf

                <!-- Nombre -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre de la Dirección</label>
                            <input type="text" id="name" name="name" class="custom-input" required>
                        </div>
                    </div>
                </div>

                <!-- Barra de búsqueda y botón de limpiar en una sola fila -->
                <div class="row align-items-center">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="addressInput">Dirección</label>
                            <input type="text" id="addressInput" class="custom-input" placeholder="Ingresa una dirección" />
                            <div id="suggestions"></div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button id="clearButton" class="custom-button w-100 mt-4" type="button">Limpiar</button>
                    </div>
                </div>

                <!-- Campo oculto para la ubicación -->
                <input type="hidden" id="location" name="location">
                
                <!-- Contenedor del mapa -->
                <div id="map-container" class="map-container">
                    <div id="map"></div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <br>
                <div class="button-container text-left">
                    <button type="submit" class="btn btn-primary">Guardar Dirección</button>
                </div>
            </form>
        </div>

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
        <!-- Leaflet GeoSearch -->
        <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
        @include('user.partials.scripts')
        <script>
            // Evento para el botón de limpiar
            document.getElementById('clearButton').addEventListener('click', function(event) {
                // Prevenir el comportamiento por defecto del botón
                event.preventDefault();
                // Limpiar el campo de búsqueda
                document.getElementById('addressInput').value = '';
                // Limpiar las sugerencias
                document.getElementById('suggestions').innerHTML = '';
                // Restaurar el mapa a la vista inicial
                map.setView([10.487, -66.879], 50);
                marker.setLatLng([10.487, -66.879]);
                // Limpiar el campo oculto
                document.getElementById('location').value = '';
            });
            // Función para obtener la ubicación del dispositivo y ajustar el mapa
            function setDefaultLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lon = position.coords.longitude;

                        // Inicializar el mapa con la ubicación del dispositivo
                        var map = L.map('map').setView([lat, lon], 50); // Ubicación del dispositivo

                        // Añadir capa de OpenStreetMap
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        // Crear un marcador en la ubicación del dispositivo
                        var marker = L.marker([lat, lon]).addTo(map);

                        // Guardar las coordenadas en el campo oculto
                        document.getElementById('location').value = `${lat} ${lon}`;

                        // Función para obtener las sugerencias de dirección
                        function getSuggestions(query) {
                            var url = `https://nominatim.openstreetmap.org/search?format=json&limit=5&q=${encodeURIComponent(query)}`;

                            fetch(url)
                                .then(response => response.json())
                                .then(data => {
                                    var suggestionsContainer = document.getElementById('suggestions');
                                    suggestionsContainer.innerHTML = ''; // Limpiar las sugerencias previas

                                    if (data.length > 0) {
                                        data.forEach(function(item) {
                                            var suggestion = document.createElement('div');
                                            suggestion.textContent = item.display_name;
                                            suggestion.addEventListener('click', function() {
                                                selectAddress(item); // Seleccionar la dirección
                                            });
                                            suggestionsContainer.appendChild(suggestion);
                                        });
                                    } else {
                                        suggestionsContainer.innerHTML = '<div>No se encontraron resultados.</div>';
                                    }
                                })
                                .catch(error => {
                                    console.error('Error en la obtención de sugerencias:', error);
                                });
                        }

                        // Función para seleccionar una dirección de las sugerencias
                        function selectAddress(item) {
                            var addressInput = document.getElementById('addressInput');
                            addressInput.value = item.display_name;

                            // Mover el marcador a la ubicación seleccionada
                            var lat = item.lat;
                            var lon = item.lon;
                            marker.setLatLng([lat, lon]);

                            // Centrar el mapa en la ubicación seleccionada
                            map.setView([lat, lon], 50);

                            // Guardar las coordenadas en el campo oculto
                            document.getElementById('location').value = `${lat} ${lon}`;

                            // Limpiar las sugerencias
                            document.getElementById('suggestions').innerHTML = '';
                        }

                        // Evento para mostrar sugerencias mientras el usuario escribe
                        document.getElementById('addressInput').addEventListener('input', function(event) {
                            var query = event.target.value;

                            if (query.length > 2) { // Solo buscar si el texto tiene más de 2 caracteres
                                getSuggestions(query);
                            } else {
                                document.getElementById('suggestions').innerHTML = ''; // Limpiar sugerencias
                            }
                        });

                        // Función para mover el marcador cuando el usuario hace clic en el mapa
                        map.on('click', function(e) {
                            var latlng = e.latlng;
                            marker.setLatLng(latlng);

                            // Guardar la latitud y longitud en el campo oculto en formato adecuado (separado por un espacio)
                            document.getElementById('location').value = `${latlng.lat} ${latlng.lng}`;
                        });

                    }, function(error) {
                        console.error("Error al obtener la geolocalización:", error);
                        alert("No se pudo obtener la ubicación del dispositivo. Se usará una ubicación predeterminada.");
                        // Si no se puede obtener la ubicación, usa una ubicación predeterminada
                        setDefaultLocationFallback();
                    });
                } else {
                    alert("La geolocalización no está soportada en este navegador.");
                    // Si la geolocalización no está disponible, usa una ubicación predeterminada
                    setDefaultLocationFallback();
                }
            }

            // Fallback en caso de que no se obtenga la ubicación del dispositivo
            function setDefaultLocationFallback() {
                var lat = 10.487; // Latitud predeterminada
                var lon = -66.879; // Longitud predeterminada

                var map = L.map('map').setView([lat, lon], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var marker = L.marker([lat, lon]).addTo(map);

                document.getElementById('location').value = `${lat} ${lon}`;
            }

            // Llamar a la función para establecer la ubicación al cargar la página
            setDefaultLocation();

            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var preloader = document.getElementById('preloader');
                    if (preloader) {
                        preloader.style.display = 'none';
                    }
                }, 5000);
            });
        </script>

</body>

</html>
