<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results in Performance</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background: url('assets/images/fondo.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 50px;
            width: 450px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            color: #333333;
        }

        .login-container img {
            width: 200px;
            margin-top: 30px;
        }

        .login-container .form-control {
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 18px;
            padding: 15px;
        }

        .login-container .btn {
            background-color: #007bff;
            color: #ffffff;
            border-radius: 10px;
            padding: 15px;
            width: 100%;
            font-weight: 700;
            font-size: 18px;
        }

        .login-container .btn:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #ff4c4c;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Acceso</h2>
        
        <!-- Mensaje de error si hay un error de login -->
        @if($errors->has('login_error'))
            <div class="error-message">
                {{ $errors->first('login_error') }}
            </div>
        @endif
        
        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn">ENTRAR</button>
            <img src="assets/images/rip_logocolores.png" alt="Logo">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>