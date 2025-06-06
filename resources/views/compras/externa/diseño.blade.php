<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results in Performance</title>
    <!-- Importar la fuente Maven Pro de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Maven Pro', Arial, sans-serif;
            /* Aplicar la fuente Maven Pro */
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
            max-width: 700px;
            position: relative;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 40px;
            display: flex;
            flex-direction: column;
            /* Disponer los elementos en columna */
            align-items: center;
            /* Centrar el contenido horizontalmente */
            justify-content: center;
            /* Centrar el contenido verticalmente */
            height: 250px;
            /* Asegurar que todas las cards tengan el mismo tamaño */
            max-width: 700px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .logo {
            width: 100px;
            /* Reducir el tamaño del logo */
            height: auto;
            margin-bottom: 20px;
            /* Separar el logo del texto */
        }

        .logo img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .description {
            font-size: 18px;
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
        <!-- Primera tarjeta con el logo centrado y más pequeño -->
        <a href="{{ url('/Directorio') }}" target="_blank">
            <div class="card">
                <div class="logo">
                    <img src="/assets/images/RIP_Logo_Color (2).png" alt="Logo de la empresa">
                </div>
                <div class="title">Registrarse en el banco de proveedores</div>
                <div class="description">Ingresa tus datos y regístrate.</div>
            </div>
        </a>
        <!-- Segunda tarjeta sin logo pero del mismo tamaño -->
        <a href="{{ url('/login') }}" target="_blank">
            <div class="card">
                <div class="logo">
                    <img src="/assets/images/RIP_Logo_Color (2).png" alt="Logo de la empresa">
                </div>
                <div class="title">Iniciar sesión como proveedor</div>
                <div class="description">Iniciar sesión.</div>
            </div>
        </a>
    </div>
</body>

</html>