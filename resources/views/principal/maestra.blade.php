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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">


    <!-- Datatables 1.13.1  v.5.2 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />

    <!--Animación -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.css​">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.css">
    
    <!--Archivo css -->
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="assets/css/organigrama.css">




</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; background-image: url(/assets/images/Logo3.png); background-size: cover;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav1">
                <ul class="navbar-nav">
                    <li class="nav-item" style="margin-right: 25px;">
                        <a class="nav-link" href="{{ url('/vacantes') }}">
                            <i class="bi bi-file-earmark-person-fill text-white" style="font-size: 24px;"></i> 
                        </a>
                    </li>
                    
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
    

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0, 124, 186, 0.850); -webkit-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); -moz-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75);">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="/" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-speedometer" style="margin-right: 5px;"></i> <span class="d-lg-none">Tablero</span><span class="d-none d-lg-inline">Tablero</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff;  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-building" style="margin-right: 5px;"></i> <span class="d-lg-none">Organización</span><span class="d-none d-lg-inline">Organización</span>
                        </a>

                        <ul class="dropdown-menu" >
                            <li><a class="dropdown-item" href="{{ url('/organigrama') }}">Organigrama</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/DPT')}}">DPT</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/PPT')}}">PPT</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/requerimiento')}}">Requerimiento Personal</a></li>
                        </ul>
                        
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-diagram-3-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Reclutamiento</span><span class="d-none d-lg-inline">Reclutamiento</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-file-earmark-ppt-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Selección</span><span class="d-none d-lg-inline">Selección</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-file-earmark-ppt-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Contratación</span><span class="d-none d-lg-inline">Contratación</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-file-earmark-bar-graph-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Rec.Empleados</span><span class="d-none d-lg-inline">Rec.Empleados</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-person-lines-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Capacitación</span><span class="d-none d-lg-inline">Capacitación</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-person-lines-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Eval.desempeño</span><span class="d-none d-lg-inline">Eval.desempeño</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-file-earmark-check-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Desvinculación</span><span class="d-none d-lg-inline">Desvinculación</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 10px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-people-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Usuarios</span><span class="d-none d-lg-inline">Usuarios</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    


    <div style="margin-top: 25px;"> 
        @yield('contenido')
    </div>


    <!-- Jquery 3.6.4-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!--Bootstrap -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>


    <!-- Datatables 1.13.1  v.5.2 -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <!-- Animación -->
    <script src="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.js"></script>
    <!-- Banco CV -->
    <script src="/assets/js_sitio/bancocv.js"></script>
    
    <!-- organización -->
    <script src="/assets/js_sitio/organizacion/organigrama.js"></script>

    <script src="/assets/js_sitio/organizacion/PPT.js"></script>
    <script src="/assets/js_sitio/organizacion/DPT.js"></script>


  
    <!-- Organigrama-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.5.1/joint.min.js"></script>
<!-- Incluir la librería SheetJS desde una CDN -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>

</body>
</html>
