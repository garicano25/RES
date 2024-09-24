<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results in Performance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .container {
            text-align: center;
            width: 80%;
            max-width: 700px; /* Aumenta el ancho máximo del contenedor */
            position: relative;
        }
        .logo {
            position: absolute;
            top: 10px; /* Ajusta la posición vertical del logo */
            right: 10px; /* Ajusta la posición horizontal del logo */
            width: 140px; /* Aumenta el tamaño del contenedor del logo */
            height: auto; /* Mantiene el tamaño automático */
            max-width: 150px; /* Define un tamaño máximo para el ancho */
            max-height: 150px; /* Define un tamaño máximo para el alto */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10; /* Asegura que el logo esté siempre por encima */
            transition: opacity 0.3s ease; /* Transición para ocultar el logo */
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Ajusta el tamaño de la imagen dentro del contenedor */
        }
        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 30px 0; /* Aumenta el margen entre las cards */
            padding: 40px; /* Aumenta el padding de las cards */
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card:hover ~ .logo {
            opacity: 0; /* Oculta el logo al hacer hover en una card */
        }
        .icon {
            width: 120px; /* Aumenta el tamaño del contenedor del icono */
            height: 120px;
            margin-bottom: 20px;
            background-color: #e0e0e0; /* Lugar para tu icono */
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .icon img {
            width: 80%; /* Aumenta el tamaño de la imagen del icono */
            height: 80%;
            object-fit: contain; /* Ajusta el tamaño de la imagen dentro del contenedor */
        }
        .title {
            font-size: 28px; /* Aumenta el tamaño de la fuente del título */
            font-weight: bold;
            margin-bottom: 15px;
        }
        .description {
            font-size: 20px; /* Aumenta el tamaño de la fuente de la descripción */
            color: #555;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="/assets/images/RIP_Logo_Color (2).png" alt="Logo de la empresa">
        </div>
        <a href="https://results-erp.results-in-performance.com/Formulario-vacantes" target="_blank">
            <div class="card">
                <div class="icon">
                    <img src="/assets/images/cv.png" alt="Icono de CV">
                </div>
                <div class="title">Registrarse en el banco de CV</div>
                <div class="description">Ingresa tus datos y regístrate.</div>
            </div>
        </a>
        <a href="https://results-erp.results-in-performance.com/Vacantes" target="_blank">
            <div class="card">
                <div class="icon">
                    <img src="/assets/images/aaaaaa.png" alt="Icono de Vacantes">
                </div>
                <div class="title">Vacantes disponibles</div>
                <div class="description">Consulta las vacantes abiertas y postúlate.</div>
            </div>
        </a>
    </div>
</body>
</html>
