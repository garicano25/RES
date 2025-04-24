<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
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

    <!-- Select opcion selectize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"> <!--Archivo css -->
    <link rel="stylesheet" href="assets/css/estilos.css">


    <link rel="stylesheet" href="assets/css/organigrama.css">



    @if(request()->is('DPT'))
    <link rel="stylesheet" href="assets/css/dpt.css">
    @endif

    @if(request()->is('Contratación'))
    <!-- form_wizard_steps -->
    <link href="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_style.css" rel="stylesheet">
    </link>
    @endif




    <style>
        .dropdown-menu {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            text-align: center;
        }

        .dropdown-item button {
            border: none;
            background: none;
            width: 100%;
            text-align: center;
            padding: 8px;
        }

        .dropdown-item button:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item span.badge {
            font-size: 0.85rem;
        }
    </style>


</head>

<body class="body">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #A4D65E; height: 100px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">
            </a>
            <!-- Contenedor para centrar el título -->
            <div class="d-flex justify-content-center align-items-center w-100" style="position: absolute; top: 0; left: 0; height: 100px;">
                <h1 class="text-white m-0" style="color:#ffff;font-weight: bold;">Recursos Humanos</h1>
            </div>
            <!-- Menú lateral derecho -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav1">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" style="margin-right: 45px;">
                        @auth
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill text-white" style="font-size: 24px;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="min-width: 250px;">
                            <li class="dropdown-item text-center">
                                <strong>{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}</strong>
                                <br>
                                <small>{{ Auth::user()->EMPLEADO_CORREO }}</small>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-center" style="color: red;">
                                        <i class="bi bi-power"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                        @else
                        <script>
                            window.location.href = "{{ route('login') }}"; // Redirige al login si no está autenticado
                        </script>
                        @endauth
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
                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link BOTON" href="{{ url('/Módulos') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-grid-3x3-gap-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Inicio</span><span class="d-none d-lg-inline">Inicio</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link BOTON" href="{{ url('/tablero') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-speedometer" style="margin-right: 5px;"></i> <span class="d-lg-none">Tablero</span><span class="d-none d-lg-inline">Tablero</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-diagram-3-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Organización</span><span class="d-none d-lg-inline">Organización</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/organigrama') }}">Organigrama</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/PPT')}}">PPT</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/DPT')}}">DPT</a></li>


                            @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador']))
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/RequisiciónDePersonal')}}">Requisición de personal </a></li>
                            @endif

                        </ul>
                    </li>

                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-lines-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Reclutamiento</span><span class="d-none d-lg-inline">Reclutamiento</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/Listavacantes') }}">Banco de CV</a></li>
                            @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador']))

                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/Postulaciones')}}">Vacantes activas</a></li>

                            @endif
                        </ul>
                    </li>

                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador']))
                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-badge-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Selección</span><span class="d-none d-lg-inline">Selección</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/Selección') }}">Selección</a></li>
                            <hr class="dropdown-divider">

                            <li><a class="dropdown-item" href="{{url('/Visualizar_selección')}}">Visualizar </a></li>
                        </ul>
                    </li>



                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-badge-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Contratación</span><span Contrataciónclass="d-none d-lg-inline">Contratación</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/Pendiente-Contratar') }}">Pendientes por contratar</a></li>
                            <hr class="dropdown-divider">

                            <li><a class="dropdown-item" href="{{url('/Contratación')}}">Lista de colaboradores</a></li>
                        </ul>
                    </li>

                    @endif

                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link BOTON" href="{{ url('/Rec.Empleado') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-briefcase-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Rec.Empleados</span><span class="d-none d-lg-inline">Rec.Empleados</span>
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador']))

                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-bounding-box" style="margin-right: 5px;"></i> <span class="d-lg-none">Capacitación</span><span Contrataciónclass="d-none d-lg-inline">Capacitación</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/') }}">Brecha</a></li>
                            <hr class="dropdown-divider">

                            <li><a class="dropdown-item" href="{{url('/')}}">Capacitación</a></li>
                        </ul>
                    </li>

                    @endif


                    {{-- <li class="nav-item dropdown" style="margin-left: 8px;">
                    <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                        <i class="bi bi-clipboard-data-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Eval.desempeño</span><span class="d-none d-lg-inline">Eval.desempeño</span>
                    </a>
                </li> --}}

                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador']))


                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link BOTON" href="{{ url('/Desvinculación') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-person-dash-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Desvinculación</span><span class="d-none d-lg-inline">Desvinculación</span>
                        </a>
                    </li>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" style="margin-left: 8px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-fill" style="margin-right: 5px;"></i>
                                <span class="d-lg-none">Catálogos</span>
                                <span class="d-none d-lg-inline">Catálogos</span>
                            </a>
                            <ul class="dropdown-menu">

                                <li><a class="dropdown-item" href="{{url('/Catálogo_ppt')}}">Catálogos de PPT</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/Catálogo_dpt')}}">Catálogos de DPT</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/Catálogo_requisición')}}">Catálogos de Requisición</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/Catálogo_generales')}}">Catálogos generales</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                    @endif
                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador']))
                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        <a class="nav-link BOTON" href="{{ url('/usuario') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-people-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Usuarios</span><span class="d-none d-lg-inline">Usuarios</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


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





    <!-- Modal de carga -->
    <style>
        #modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Ajusta la opacidad aquí */
            z-index: 999;
            display: none;
            /* Empieza oculto */
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 28%;
        }
    </style>
    <div id="modal-overlay">
        <img src="/assets/images/Colorancho.png" class="ld ld-bounce" alt="Cargando" style="max-width: 100%; max-height: 214px;" id="loading-image">
    </div>


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
    <!-- Select opcion selectize -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>


    <!-- datepicker -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.es.min.js"></script>



    <!-- Dropify -->

    <script src="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>

    <!-- Funciones generales -->
    <script src="/assets/js_sitio/funciones.js?v=5.0"></script>


    <script>
        $(document).ready(function() {
            // Inicializar campos datepicker con opciones en español
            $('.mydatepicker').datepicker({
                format: 'yyyy-mm-dd', // Formato de fecha
                weekStart: 1, // Día que inicia la semana, 1 = Lunes
                autoclose: true, // Cierra automáticamente el calendario
                todayHighlight: true, // Marca el día de hoy en el calendario
                language: 'es' // Configura el idioma en español
            });

            // Mostrar la fecha seleccionada en el input
            $('.mydatepicker').on('click', function() {
                $(this).datepicker('setDate', $(this).val()); // Mostrar fecha del input y marcar en el calendario
            });
        });
    </script>




    @if(request()->is('organigrama'))
    <script src="/assets/js_sitio/organizacion/organigrama.js?v=4.0"> </script>
    <script src="/assets/js/GOJs/go.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    @endif

    @if(request()->is('PPT'))
    <script src="/assets/js_sitio/organizacion/PPT.js?v=3.0"></script>
    @endif

    @if(request()->is('DPT'))
    <script src="/assets/js_sitio/organizacion/DPT.js?v=6.0"></script>
    @endif

    @if(request()->is('Jerárquico'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogos.js?v=1.0"></script>
    @endif

    @if(request()->is('Asesores'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoasesores.js?v=1.0"></script>
    @endif


    @if(request()->is('FuncionesCargo'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogofuncionescargo.js?v=1.0"></script>
    @endif

    @if(request()->is('Funcionesgestión'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogofuncionesgestion.js?v=3.0"></script>
    @endif

    @if(request()->is('RelacionesExternas'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogosrelacionesxternas.js?v=1.0"></script>
    @endif

    @if(request()->is('RequisiciónDePersonal'))
    <script src="/assets/js_sitio/organizacion/requerimiento.js?v=3.0"></script>
    @endif

    @if(request()->is('CatálogoDeVacantes'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogovacantes.js?v=1.0"></script>
    @endif

    @if(request()->is('Categorías'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogocategoria.js?v=4.0"></script>
    @endif

    @if(request()->is('Género'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogogenero.js?v=1.0"></script>
    @endif


    @if(request()->is('Puesto-experiencia'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoexperiencia.js?v=1.0"></script>
    @endif


    @if(request()->is('Competencias-básicas'))
    <script src="/assets/js_sitio/organizacion/catalogos/catálogocompetenciabasica.js?v=1.0"></script>
    @endif


    @if(request()->is('Tipo-vacante'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogotipovacante.js?v=1.0"></script>
    @endif

    @if(request()->is('Competencias-gerenciales'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoCompetenciasGerenciales.js?v=1.0"></script>
    @endif



    @if(request()->is('Anuncios'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoanuncion.js"></script>
    @endif



    @if(request()->is('Listavacantes'))
    <script src="/assets/js_sitio/reclutamiento/Listavacante.js"></script>
    @endif

    @if(request()->is('Postulaciones'))
    <script src="/assets/js_sitio/reclutamiento/vacantesactivas.js?v=6.0"></script>
    @endif

    @if(request()->is('Motivo-vacante'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogomotivovacante.js?v=1.0"></script>
    @endif


    @if(request()->is('Área_interes'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoareainteres.js?v=1.0"></script>
    @endif


    @if(request()->is('Selección'))
    <script src="/assets/js_sitio/seleccion/seleccion.js?v=20.8"></script>
    @endif

    @if(request()->is('Visualizar_selección'))
    <script src="/assets/js_sitio/seleccion/visualizarseleccion.js?v=1.0"></script>
    @endif

    @if(request()->is('Pruebas-conocimientos'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogopruebas.js?v=1.0"></script>
    @endif


    @if(request()->is('usuario'))
    <script src="/assets/js_sitio/usuario/usuario.js?v=4.1"></script>
    @endif

    @if(request()->is('Contratación'))
    <script src="/assets/js_sitio/contratacion/contratacion.js?v=11.5"></script>
    <!-- Form wizard -->
    <script src="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_script.js"></script>
    @endif


    @if(request()->is('Pendiente-Contratar'))
    <script src="/assets/js_sitio/contratacion/pendientecontratar.js?v=1.0"></script>
    @endif



    @if(request()->is('Desvinculación'))
    <script src="/assets/js_sitio/desvinculacion/desvinculacion.js"></script>
    @endif




</body>

</html>