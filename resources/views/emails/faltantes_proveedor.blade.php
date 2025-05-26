<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">


    <style>
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }

        .button {
            display: inline-block;
            background-color: #2C3E50;
            color: #ffffff;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #1a252f;
        }

        .footer a {
            color: #2C3E50;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <p>{{ $saludo }} proveedor {{ $razonSocial }},</p>

    <p>Detectamos que su registro aún está incompleto. A continuación se describen los elementos que faltan:</p>

    <ul>
        @foreach ($faltantes as $item)
        <li>{{ $item }}</li>
        @endforeach
    </ul>

    <p>Le pedimos completar la información a la brevedad para continuar con el proceso de validación.</p>

    <br>

    <p>Saludos cordiales.</p>


    <div class="footer">
        <p>&copy; {{ date('Y') }} <a href="https://results-in-performance.com">Results In Performance</a>. Todos los derechos reservados.</p>
    </div>

</body>

</html>