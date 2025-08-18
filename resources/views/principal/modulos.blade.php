<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results In Performance</title>
    <link href="assets/css/mobile.css" rel="stylesheet" media="all and (max-width: 600px)">
    <link href="assets/css/desktop.css" rel="stylesheet" media="all and (min-width: 600px)">


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .lineasDeNegocio__iconsm,
        .content__noticias img,
        .modules__circle img,
        .softwares__image,
        .learning__image img {
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .lineasDeNegocio__iconsm:hover,
        .content__noticias img:hover,
        .modules__circle img:hover,
        .softwares__image:hover,
        .learning__image img:hover {
            transform: scale(1.1);
            filter: brightness(1.2);
        }



        .softwares__card,
        .softwares__greyCard {
            height: 25vh;
            width: 48%;
            background-color: #ff585d;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0.5em;
        }

        .softwares__card img,
        .softwares__greyCard img {
            height: 9em;
            width: 9em;
            padding-top: 0em;
        }

        .lineasDeNegocio__iconButton {
            transition: transform 0.3s ease, background-color 0.3s ease;
            border: none;
            background: none;
            cursor: pointer;
        }

        .lineasDeNegocio__iconButton:hover {
            transform: scale(1.2);
            background-color: rgba(0, 0, 0, 0.1);
        }


        .content__title,
        .content__paragraph,
        .modules__text,
        .learning__title,
        .learning__link {
            transition: color 0.3s ease;
        }

        .content__title:hover,
        .content__paragraph:hover,
        .modules__text:hover,
        .learning__title:hover,
        .learning__link:hover {
            color: #007bff;
        }


        .lineasDeNegocio__image img {
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .lineasDeNegocio__image:hover img {
            transform: scale(1.1);
            filter: brightness(1.2);
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltipText {
            position: absolute;
            top: 50%;
            left: 110%;
            transform: translateY(-50%);
            background-color: #333;
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
            white-space: nowrap;
            font-size: 13px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .tooltip:hover .tooltipText {
            opacity: 1;
            visibility: visible;
        }

        .tooltipText::after {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            transform: translateY(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: transparent #333 transparent transparent;
        }

        .learning {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            padding: 20px;
            color: #000;
        }

        .learning__title,
        .learning__link {
            color: #000 !important;
        }


        .content__noticias,
        .modules__card,
        .softwares__card,
        .softwares__greyCard,
        .learning {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content__noticias:hover,
        .modules__card:hover,
        .softwares__card:hover,
        .softwares__greyCard:hover,
        .learning:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }



        .content__noticias {
            display: flex;
            align-items: center;
            background-color: #ff5b5b;
            border-radius: 20px;
            margin-bottom: 20px;
            padding: 15px;
            gap: 20px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .content__noticias:hover {
            transform: scale(1.01);
        }

        .content__noticiasImage {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            /* 👈 hace la imagen circular */
            overflow: hidden;
            flex-shrink: 0;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content__noticiasImage img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            /* 👈 mantiene el círculo en la imagen */
        }


        .content__noticiasText {
            flex-grow: 1;
        }

        .content__title {
            font-size: 1.1rem;
            font-weight: bold;
            margin: 0 0 5px;
            color: white;
        }

        .content__paragraph {
            font-size: 0.9rem;
            color: white;
            margin: 0;
        }

        .modal-anuncio {
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-contenido {
            background: white;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            border-radius: 15px;
            text-align: center;
            position: relative;
        }

        .modal-contenido img {
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
            object-fit: cover;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .cerrar {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .carrusel {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .carrusel-slide {
            display: none;
            width: 100%;
            animation: fade 0.5s ease-in-out;
        }

        .carrusel-slide.activo {
            display: block;
        }

        @keyframes fade {
            from {
                opacity: 0.5;
            }

            to {
                opacity: 1;
            }
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <section>





        <div class="erp">
            <div class="lineasDeNegocio">
                <div class="lineasDeNegocio__image">
                    <img src="{{ route('usuariofoto', auth()->user()->ID_USUARIO) }}" alt="">
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/1-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES EN CALIDAD</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/2-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES LIDERAZGO Y HAB. HUMANAS</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/3-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES TÉCNICAS</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/4-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES MEDIO AMBIENTE</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/5-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES EN SST</span>
                </div>

                <div class="lineasDeNegocio__servicios"></div>

                <div class="tooltip lineasDeNegocio__button">
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="button" id="logoutButton" class="lineasDeNegocio__iconButton">
                            <img src="assets/Modulos/img/salir.png" alt="">
                        </button>
                    </form>

                    <span class="tooltipText">Cerrar sesión</span>
                </div>
            </div>


            <div class="panel">

                <div class="nav">
                    <div class="nav__usuario">
                        <h2>Hola, {{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}</h2>
                    </div>

                    <div class="nav__buttons">
                        <div class="tooltip">
                            <a href="https://results-in-performance.com" target="_blank" class="nav__emailLink">
                                <button class="nav__circularButton">
                                    <img src="assets/Modulos/img/sitoweb.png" alt="">
                                </button>
                            </a>
                            <span class="tooltipText">Sitio web</span>
                        </div>

                        <div class="tooltip">
                            <a href="https://mail.google.com/mail/u/0/#inbox?compose=new" target="_blank" class="nav__emailLink">
                                <button class="nav__circularButton">
                                    <img src="assets/Modulos/img/email.png" alt="">
                                </button>
                            </a>
                            <span class="tooltipText">Correo electrónico</span>
                        </div>

                        <div class="tooltip">
                            <button class="nav__circularButton">
                                <img src="assets/Modulos/img/notificacion.png" alt="">
                            </button>
                            <span class="tooltipText">Notificaciones</span>
                        </div>
                    </div>
                </div>

                <div class="content">

                    <div class="content__left">
                        {{-- CARRUSEL: Anuncios del Día o Año --}}
                        @if($anunciosDiaAnio->isNotEmpty())
                        <div class="carrusel" id="carruselDiaAnio">
                            @foreach ($anunciosDiaAnio as $index => $anuncio)
                            <div class="carrusel-slide {{ $index === 0 ? 'activo' : '' }}"
                                data-imagen="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}"
                                data-titulo="{{{ $anuncio->TITULO_ANUNCIO }}}"
                                data-descripcion="{{{ $anuncio->DESCRIPCION_ANUNCIO }}}"
                                onclick="mostrarModalDesdeData(this)">
                                <div class="content__noticias">
                                    <div class="content__noticiasImage">
                                        <img src="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}" alt="Imagen del anuncio">
                                    </div>
                                    <div class="content__noticiasText">
                                        <h3 class="content__title">{{ $anuncio->TITULO_ANUNCIO }}</h3>
                                        <p class="content__paragraph">{{ Str::limit($anuncio->DESCRIPCION_ANUNCIO, 80, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else

                        @endif

                        {{-- CARRUSEL: Anuncios del Mes --}}
                        @if($anunciosMes->isNotEmpty())
                        <div class="carrusel" id="carruselMes">
                            @foreach ($anunciosMes as $index => $anuncio)
                            <div class="carrusel-slide {{ $index === 0 ? 'activo' : '' }}"
                                data-imagen="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}"
                                data-titulo="{{{ $anuncio->TITULO_ANUNCIO }}}"
                                data-descripcion="{{{ $anuncio->DESCRIPCION_ANUNCIO }}}"
                                onclick="mostrarModalDesdeData(this)">
                                <div class="content__noticias">
                                    <div class="content__noticiasImage">
                                        <img src="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}" alt="Imagen del anuncio">
                                    </div>
                                    <div class="content__noticiasText">
                                        <h3 class="content__title">{{ $anuncio->TITULO_ANUNCIO }}</h3>
                                        <p class="content__paragraph">{{ Str::limit($anuncio->DESCRIPCION_ANUNCIO, 80, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else

                        @endif




                        <div class="widget">
                            <div class="widget__area" id="DIV_CLIMA"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const widgetArea = document.getElementById("DIV_CLIMA");

                                    function getWeatherByLocation() {
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(success, error);
                                        } else {
                                            widgetArea.innerHTML = "Geolocalización no soportada.";
                                        }
                                    }

                                    function success(position) {
                                        const lat = position.coords.latitude;
                                        const lon = position.coords.longitude;
                                        fetchWeather(lat, lon);
                                    }

                                    function error() {
                                        widgetArea.innerHTML = "No se pudo obtener la ubicación.";
                                    }

                                    function fetchWeather(lat, lon) {
                                        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true&timezone=auto`;

                                        fetch(url)
                                            .then(response => response.json())
                                            .then(data => {
                                                const temperature = data.current_weather.temperature;
                                                const windSpeed = data.current_weather.windspeed;
                                                const weatherCode = data.current_weather.weathercode;

                                                const weatherDescriptions = {
                                                    0: "Despejado ☀️",
                                                    1: "Mayormente despejado 🌤",
                                                    2: "Parcialmente nublado ⛅",
                                                    3: "Nublado ☁️",
                                                    45: "Niebla 🌫",
                                                    48: "Niebla helada ❄️🌫",
                                                    51: "Llovizna ligera 🌦",
                                                    53: "Llovizna moderada 🌧",
                                                    55: "Llovizna intensa 🌧",
                                                    61: "Lluvia ligera 🌧",
                                                    63: "Lluvia moderada 🌧",
                                                    65: "Lluvia intensa ⛈",
                                                    80: "Chubascos ligeros 🌦",
                                                    81: "Chubascos moderados 🌦",
                                                    82: "Chubascos intensos ⛈",
                                                    95: "Tormenta ⛈",
                                                    99: "Tormenta fuerte ⛈⚡"
                                                };

                                                const description = weatherDescriptions[weatherCode] || "Clima desconocido";

                                                widgetArea.innerHTML = `
                                                    <div class="weather-widget">
                                                        <h3>Clima Actual</h3>
                                                        <p class="temperature">${temperature}°C</p>
                                                        <p class="description">${description}</p>
                                                        <p>💨 Viento: ${windSpeed} km/h</p>
                                                        <p class="updated-time">⏰ Actualizado: <span id="current-time"></span></p>
                                                    </div>
                                                `;

                                                updateClock();
                                                setInterval(updateClock, 1000);
                                            })
                                            .catch(() => {
                                                widgetArea.innerHTML = "No se pudo obtener el clima.";
                                            });
                                    }

                                    function updateClock() {
                                        const now = new Date();
                                        const formattedTime = now.toLocaleTimeString("es-MX", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                            second: "2-digit"
                                        });
                                        const clockElement = document.getElementById("current-time");
                                        if (clockElement) {
                                            clockElement.innerText = formattedTime;
                                        }
                                    }

                                    getWeatherByLocation();
                                });
                            </script>

                            <style>
                                .widget__area {
                                    background: linear-gradient(to right, #236192, #007DBA);
                                    color: white;
                                    text-align: center;
                                    padding: 8px;
                                    border-radius: 15px;
                                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
                                    font-family: 'Poppins', sans-serif;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: center;
                                    align-items: center;
                                    overflow: hidden;
                                }

                                .weather-widget {
                                    width: 100%;
                                    height: 100%;
                                }


                                .temperature {
                                    font-size: 1.5vw;
                                    font-weight: bold;
                                    margin: 2px 0;
                                }

                                .description {
                                    font-size: 0.9vw;
                                    font-weight: bold;
                                    text-align: center;
                                    margin: 2px 0;
                                    white-space: normal;
                                    line-height: 1.1;
                                }

                                .updated-time {
                                    font-size: 0.7vw;
                                    opacity: 0.8;
                                    margin-top: 3px;
                                }

                                p {
                                    margin: 2px 0;
                                    line-height: 1;
                                }
                            </style>


                            <div class="widget__area" id="DIV_MONEDA">
                            </div>

                        </div>
                        <!-- 
                        @php
                        $user = auth()->user();

                        $tieneSoloRolIntendente = $user->roles->count() === 1 && $user->hasRole('Intendente');
                        $tieneSoloRolSSTJunior = $user->roles->count() === 1 && $user->hasRole('Consultor-Instructor (Junior/Senior)');
                        $tieneSoloRolAsistentePlaneacion = $user->roles->count() === 1 && $user->hasRole('Asistente de planeación y logística');

                        $tieneRolRestringidoUnico = $tieneSoloRolIntendente || $tieneSoloRolSSTJunior || $tieneSoloRolAsistentePlaneacion;
                        @endphp




                        <div class="modules">

                            {{-- RRHH --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('RRHH')">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">RRHH</h2>
                            </div>
                            @else
                            <a href="{{ url('/tablero') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                    <h2 class="modules__text">RRHH</h2>
                                </div>
                            </a>
                            @endif

                            {{-- Compras (libre) --}}
                            <a href="{{ url('/Requisición_Materiales') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Compras.png" alt=""></div>
                                    <h2 class="modules__text">Compras</h2>
                                </div>
                            </a>

                            {{-- Ventas --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Ventas')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Ventas.png" alt=""></div>
                                <h2 class="modules__text">Ventas</h2>
                            </div>
                            @else
                            <a href="{{ url('/Clientes') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Ventas.png" alt=""></div>
                                    <h2 class="modules__text">Ventas</h2>
                                </div>
                            </a>
                            @endif



                            {{-- Admón --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Admón')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Admon.png" alt=""></div>
                                <h2 class="modules__text">Admón</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Admon.png" alt=""></div>
                                <h2 class="modules__text">Admón</h2>
                            </div>
                            @endif

                            {{-- Almacén --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Almacén')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Almacén</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Almacén</h2>
                            </div>
                            @endif

                            {{-- Mantenimiento --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Mantenimiento')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Mantenimiento</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Mantenimiento</h2>
                            </div>
                            @endif

                            {{-- HSE --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('HSE')">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">HSE</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">HSE</h2>
                            </div>
                            @endif

                            {{-- Calidad --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Calidad')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Calidad.png" alt=""></div>
                                <h2 class="modules__text">Calidad</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Calidad.png" alt=""></div>
                                <h2 class="modules__text">Calidad</h2>
                            </div>
                            @endif


                            {{-- Página web --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Ventas')">
                                <div class="modules__circle"><img src="assets/Modulos/img/sitoweb.png" alt=""></div>
                                <h2 class="modules__text">Página web</h2>
                            </div>
                            @else
                            <a href="{{ url('/Mensajes_paginaweb') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/sitoweb2.png" alt=""></div>
                                    <h2 class="modules__text">Página web</h2>
                                </div>
                            </a>
                            @endif



                        </div> -->

                        @php
                        $user = auth()->user();

                        $tieneSoloRolIntendente = $user->roles->count() === 1 && $user->hasRole('Intendente');
                        $tieneSoloRolSSTJunior = $user->roles->count() === 1 && $user->hasRole('Consultor-Instructor (Junior/Senior)');
                        $tieneSoloRolAsistentePlaneacion = $user->roles->count() === 1 && $user->hasRole('Asistente de planeación y logística');
                        $tieneSoloRolAlmacenista = $user->roles->count() === 1 && $user->hasRole('Almacenista');

                        $tieneRolRestringidoUnico = $tieneSoloRolIntendente || $tieneSoloRolSSTJunior || $tieneSoloRolAsistentePlaneacion;
                        @endphp

                        <div class="modules">

                            {{-- CASO ESPECIAL: SOLO ALMACENISTA --}}
                            @if($tieneSoloRolAlmacenista)

                            {{-- Compras -> Bitácora-GR --}}
                            <a href="{{ url('/Bitácora-GR') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Compras.png" alt=""></div>
                                    <h2 class="modules__text">Compras</h2>
                                </div>
                            </a>

                            {{-- Almacén --}}
                            <a href="{{ url('/Almacen') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                    <h2 class="modules__text">Almacén</h2>
                                </div>
                            </a>

                            @else
                            {{-- CASO GENERAL (TODOS LOS DEMÁS ROLES) --}}

                            {{-- RRHH --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('RRHH')">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">RRHH</h2>
                            </div>
                            @else
                            <a href="{{ url('/tablero') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                    <h2 class="modules__text">RRHH</h2>
                                </div>
                            </a>
                            @endif

                            {{-- Compras (libre para todos excepto Almacenista) --}}
                            <a href="{{ url('/Requisición_Materiales') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Compras.png" alt=""></div>
                                    <h2 class="modules__text">Compras</h2>
                                </div>
                            </a>

                            {{-- Ventas --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Ventas')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Ventas.png" alt=""></div>
                                <h2 class="modules__text">Ventas</h2>
                            </div>
                            @else
                            <a href="{{ url('/Clientes') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Ventas.png" alt=""></div>
                                    <h2 class="modules__text">Ventas</h2>
                                </div>
                            </a>
                            @endif

                            {{-- Admón --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Admón')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Admon.png" alt=""></div>
                                <h2 class="modules__text">Admón</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Admon.png" alt=""></div>
                                <h2 class="modules__text">Admón</h2>
                            </div>
                            @endif

                            {{-- Almacén --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Almacén')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Almacén</h2>
                            </div>
                            @else
                            <a href="{{ url('/Almacen') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                    <h2 class="modules__text">Almacén</h2>
                                </div>
                            </a>
                            @endif

                            {{-- Mantenimiento --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Mantenimiento')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Mantenimiento</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Mantenimiento</h2>
                            </div>
                            @endif

                            {{-- HSE --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('HSE')">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">HSE</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">HSE</h2>
                            </div>
                            @endif

                            {{-- Calidad --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Calidad')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Calidad.png" alt=""></div>
                                <h2 class="modules__text">Calidad</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Calidad.png" alt=""></div>
                                <h2 class="modules__text">Calidad</h2>
                            </div>
                            @endif

                            {{-- Página web --}}
                            @if($tieneRolRestringidoUnico)
                            <div class="modules__card" onclick="noPermiso('Ventas')">
                                <div class="modules__circle"><img src="assets/Modulos/img/sitoweb.png" alt=""></div>
                                <h2 class="modules__text">Página web</h2>
                            </div>
                            @else
                            <a href="{{ url('/Mensajes_paginaweb') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/sitoweb2.png" alt=""></div>
                                    <h2 class="modules__text">Página web</h2>
                                </div>
                            </a>
                            @endif

                            @endif

                        </div>





                    </div>

                    <div class="content__right">
                        <div class="softwares">
                            <div class="softwares__top">
                                <div class="softwares__card">
                                    <a href="https://sehilab-prueba.results-in-performance.com/" target="_blank">

                                        <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt="">
                                        <h3 class="content__paragraph">SEHILAB</h3>
                                    </a>

                                </div>
                                <div class="softwares__greyCard" onclick="window.open('https://wclearningexperience.results-in-performance.com/', '_blank')" style="cursor: pointer;">
                                    <h3 class="content__paragraph">WELL CONTROL</h3>
                                </div>

                            </div>

                            <div class="softwares__bottom">


                                <div class="softwares__greyCard">
                                    <!-- <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt=""> -->
                                    <h3 class="content__paragraph">TRAIN+</h3>
                                </div>
                                <div class="softwares__card">
                                    <!-- <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt=""> -->
                                    <h3 class="content__paragraph">RigCAP</h3>
                                </div>
                            </div>

                            <div class="learning">
                                <div class="learning__text">
                                    <h2 class="learning__title">E-learning</h2>
                                    <h2 class="learning__link">Saber más</h2>
                                </div>
                                <div class="learning__image">
                                    <img src="assets/Modulos/img/laptop.png" alt="">
                                </div>
                            </div>


                        </div>
                    </div>



                </div>

            </div>
            <img class="content__logo" src="assets/Modulos/img/logo.png" alt="">

        </div>




    </section>



    <!-- Modal -->
    <div id="modalAnuncio" style="display: none;" class="modal-anuncio">
        <div class="modal-contenido" onclick="event.stopPropagation()">
            <span class="cerrar" onclick="cerrarModal()">×</span>
            <img id="modalImagen" src="" alt="Imagen del anuncio" />
            <h2 id="modalTitulo"></h2>
            <p id="modalDescripcion"></p>
        </div>
    </div>



    <script>
        function noPermiso(modulo) {
            Swal.fire({
                icon: 'error',
                title: 'Acceso denegado',
                text: 'No tienes permiso para acceder al módulo de ' + modulo,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Entendido'
            });
        }
    </script>



    @if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'Acceso Denegado',
                text: 'No tienes acceso a este módulo.',
                confirmButtonText: 'Entendido',
                background: '#f8d7da', // Fondo rojo claro
                customClass: {
                    popup: 'swal-wide' // Clase personalizada para ampliar la alerta
                }
            });

        });
    </script>
    @endif


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script src="/assets/js_sitio/modulos.js?v=1.0"></script>


</body>

</html>