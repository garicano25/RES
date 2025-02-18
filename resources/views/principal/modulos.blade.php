<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results in Performance</title>
    <link href="assets/css/mobile.css" rel="stylesheet" media="all and (max-width: 600px)">
    <link href="assets/css/desktop.css" rel="stylesheet" media="all and (min-width: 600px)">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


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

                <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/1-negocio.png" title="SOLUCIONES EN CALIDAD" alt="">
                <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/2-negocio.png" title="SOLUCIONES LIDERAZGO Y HAB. HUMANAS" alt="">
                <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/3-negocio.png" title="SOLUCIONES TÉCNICAS" alt="">
                <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/4-negocio.png" title="SOLUCIONES MEDIO AMBIENTE" alt="">
                <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/5-negocio.png" title="SOLUCIONES EN SST" alt="">

                <div class="lineasDeNegocio__servicios"></div>
                <div class="lineasDeNegocio__button">
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="lineasDeNegocio__iconButton">
                            <img src="assets/Modulos/img/salir.png" alt="" title="Cerrar sesión">
                        </button>
                    </form>
                </div>


            </div>
            <div class="panel">

                <div class="nav">
                    <div class="nav__usuario">
                        <h2>Hola, {{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}</h2>
                    </div>

                    <div class="nav__buttons">
                        <a href="https://results-in-performance.com" target="_blank" class="nav__link">
                            <div>
                                <button class="nav__button">Sitio web <img src="assets/Modulos/img/flecha.png" alt=""></button>
                            </div>
                        </a>
                        <div>
                            <a href="https://mail.google.com/mail/u/0/#inbox?compose=new" target="_blank" class="nav__emailLink">
                                <button class="nav__circularButton">
                                    <img src="assets/Modulos/img/email.png" alt="">
                                </button>
                            </a>
                        </div>
                        <div><button class="nav__circularButton"><img src="assets/Modulos/img/notificacion.png" alt=""></button></div>
                    </div>
                </div>

                <div class="content">

                    <div class="content__left">
                        <div class="content__noticias">
                            <div class="content__noticiasImage"><img src="assets/Modulos/img/pastel.png" alt=""></div>
                            <div class="content__noticiasText">
                                <h3 class="content__title">Lorem Ipsum </h3>
                                <h3 class="content__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis expedita perferendis beatae, suscipit ipsam mollitia quis nemo. Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis expedita perferendis beatae, suscipit ipsam mollitia quis nemo.</h3>
                            </div>
                        </div>

                        <div class="content__noticias">
                            <div class="content__noticiasImage"><img src="assets/Modulos/img/pastel.png" alt=""></div>
                            <div class="content__noticiasText">
                                <h3 class="content__title">Lorem Ipsum</h3>
                                <h3 class="content__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis expedita perferendis beatae, suscipit ipsam mollitia quis nemo.</h3>
                            </div>
                        </div>

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
                                    font-family: Arial, sans-serif;
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

                        <div class="modules">
                            <a href="{{ url('/tablero') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                    <h2 class="modules__text">RRHH</h2>
                                </div>
                            </a>
                            <a href="{{ url('/Requisición_Materiales') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Compras.png" alt=""></div>
                                    <h2 class="modules__text">Compras</h2>
                                </div>
                            </a>
                            <a href="{{ url('/Solicitudes') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Ventas.png" alt=""></div>
                                    <h2 class="modules__text">Ventas</h2>
                                </div>
                            </a>
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">HSE</h2>
                            </div>
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Admon.png" alt=""></div>
                                <h2 class="modules__text">Admon</h2>
                            </div>
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Almacén</h2>
                            </div>
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Calidad.png" alt=""></div>
                                <h2 class="modules__text">Calidad</h2>
                            </div>

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
                                <div class="softwares__greyCard">
                                    <!-- <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt=""> -->
                                    <h3 class="content__paragraph">BUZÓN</h3>
                                </div>
                            </div>

                            <div class="softwares__bottom">


                                <div class="softwares__greyCard">
                                    <!-- <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt=""> -->
                                    <h3 class="content__paragraph">TRAIN+</h3>
                                </div>
                                <div class="softwares__card">
                                    <!-- <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt=""> -->
                                    <h3 class="content__paragraph">RigCap</h3>
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
        </div>
        </div>

    </section>



    <script>
        document.querySelectorAll('.lineasDeNegocio__iconsm').forEach(img => {
            const originalSrc = img.src;

            img.addEventListener('mouseenter', () => {
                img.src = hoverSrc;
            });

            img.addEventListener('mouseleave', () => {
                img.src = originalSrc;
            });
        });
    </script>


</body>

</html>