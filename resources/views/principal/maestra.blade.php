<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/iconologo.png">
    <title>Results in Performance</title>

    <!-- Bootstrap  iconos v1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap v.5.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Datatables 1.13.1  v.5.2 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />

    <!--Animación -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.css​">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.css">
    
    <!--Archivo css -->
    <link rel="stylesheet" href="assets/css/estilos.css">

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; background-image: url(/assets/images/Logo3.png); background-size: cover;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item" style="margin-right: 25px;">
                        <a class="nav-link" href="#">
                            <i class="bi bi-chat-left-fill text-white" style="font-size: 24px;"></i> 
                        </a>
                    </li>
                    <li class="nav-item" style="margin-right: 45px;">
                        <a class="nav-link" href="#">
                            <i class="bi bi-person-fill text-white" style="font-size: 24px;"></i> 
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0, 124, 186, 0.850); -webkit-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75);
    -moz-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75);
    box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75);">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="/" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-layout-text-window-reverse"></i> Tablero
                        </a>
                    </li>
                    
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="{{ url('/ruta') }}" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-bank2"></i> Banco.CV
                        </a>
                    </li>
                    
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-diagram-3-fill"></i> Organigrama
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-file-earmark-ppt-fill"></i> PPT
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i> DPT
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-person-lines-fill"></i> Reclutamiento
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-person-lines-fill"></i> Selección
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-file-earmark-check-fill"></i> Contratación
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 25px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-file-earmark-arrow-up-fill"></i> Permisos internos
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 25x;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;">
                            <i class="bi bi-people-fill"></i> Usuarios
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 36px;"> <!-- Agregué un margen superior de 20px -->
        @yield('contenido')
    </div>


    <!-- Jquery 3.6.4-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Datatables 1.13.1  v.5.2 -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Animación -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.js"></script>


    <!-- Banco CV -->

    <script src="/assets/js_sitio/bancocv.js"></script>

</body>
</html>
