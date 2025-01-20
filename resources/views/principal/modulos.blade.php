<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png"> 
    <title>Results in Performance</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #007DBA, #236192);
            font-family: Arial, sans-serif;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            grid-gap: 20px;
            justify-content: center;
            align-items: center;
        }

        .circle {
            width: 100px;
            height: 100px;
            background-color: #1e637c;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .circle:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .circle img {
            width: 50%;
            height: 50%;
            object-fit: contain;
        }

        footer {
            position: absolute;
            bottom: 10px;
            text-align: center;
            width: 100%;
            color: white;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/tablero') }}" class="circle" id="rrhh"><img src="rrhh.png" alt="RRHH"></a>
        <a href="{{ url('/Solicitudes') }}" class="circle" id="ventas"><img src="ventas.png" alt="Ventas"></a>
        <a href="#" class="circle" id="compras"><img src="compras.png" alt="Compras"></a>
        <a href="#" class="circle" id="almacen"><img src="almacen.png" alt="Almacén"></a>
        <a href="#" class="circle" id="calidad"><img src="calidad.png" alt="Calidad"></a>
        <a href="#" class="circle" id="admon"><img src="admon.png" alt="Admon"></a>
    </div>


    <script>
        const circles = document.querySelectorAll('.circle');

        circles.forEach(circle => {
            circle.addEventListener('mouseover', () => {
                console.log(`Hovered over: ${circle.id}`);
            });

            circle.addEventListener('click', () => {
                console.log(`Clicked on: ${circle.id}`);
            });
        });
    </script>
</body>
</html>
