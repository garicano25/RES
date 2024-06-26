<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Select opcion selectize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/css/bootstrap.min.css">
    <style>
    

     .card {
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: transform 0.2s;
            margin-bottom: 10px; 
            border-radius: 10px; 
        }

        .card:hover {
            transform: scale(1.05);
        }

        .list-group-item {
            margin-bottom: 10px; 
            border: 1px solid #dee2e6;
            border-radius: 10px; 
            padding: 15px; 
        }

        .list-group-item.active-link {
            border-color: #007bff;
            background-color: #f0f8ff;
            border-radius: 10px; 
        }

        .details-pane {
            display: none;
            position: relative;
            width: 100%;
            height: auto;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            margin-top: 10px; 
            border-radius: 10px; 
        }

        .details-pane.active {
            display: block;
            border-color: #007bff;
            border-radius: 10px; 
        }

        .details-pane p {
            white-space: pre-wrap; 
            word-wrap: break-word; 
            font-size: 1rem; 
            line-height: 1.5; 
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 100%;
            height: auto; 
        } 


        body {
            font-family: 'Poppins', sans-serif;
            /* background-color: #007DBA; */
        }
    </style>
  
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; background-image: url(/assets/images/Logo3.png); background-size: cover;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/assets/images/rip_logoblanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">
                {{-- <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo"> --}}
            </a>
            
        </div>
    </nav>


    @php
    use Carbon\Carbon;
    @endphp


    <div class="container mt-5">
        <h2 class="text-center">¡ESTAS SON NUESTRAS <b>VACANTES</b> DISPONIBLES!</h2>
        <br><br>


        <div class="row">

            <div class="col-md-4">
                <div class="list-group">
                    @foreach($vacantes as $vacante)
                    @php
                        $slug = \Illuminate\Support\Str::slug($vacante->CATEGORIA_VACANTE);
                        $fechaFormateada = Carbon::parse($vacante->created_at)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
                    @endphp
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="showDetails('{{ $slug }}')" id="link-{{ $slug }}">
                        <h5 class="mb-1">{{ $vacante->CATEGORIA_VACANTE }}</h5> <br>
                        <label><b>Lugar de trabajo:</b> </label>
                        <label class="text-center">{{ $vacante->LUGAR_VACANTE }}</label>  <br><br>
                        <label><b>Fecha de publicación:</b></label>
                        <label class="mb-1">{{ $fechaFormateada }}</label>
                    </a>
                @endforeach
                
                
                </div>
            </div>
            <div class="col-md-8 position-relative">
                @foreach($vacantes as $vacante)
                    @php
                                            $slug = \Illuminate\Support\Str::slug($vacante->CATEGORIA_VACANTE);
                        $fechaFormateada = Carbon::parse($vacante->created_at)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
                        $requisitosFormateados = nl2br(e($vacante->DESCRIPCION));
                    @endphp
                    <div class="details-pane" id="details-{{ $slug }}">
                        <h5 class="card-title text-center">{{ $vacante->CATEGORIA_VACANTE }}</h5> <br>
                        <label><b>Lugar de trabajo:</b> </label>
                        <label>{{ $vacante->LUGAR_VACANTE }}</label> <br>
                        <label><b>Fecha de publicación:</b></label>
                        <label class="mb-1">{{ $fechaFormateada }}</label>
                        <hr>
                        <p><strong>Descripción:</strong></p>
                        <p>{{ $vacante->DESCRIPCION_VACANTE }}</p>
                        <p><strong>Requisitos:</strong></p>
                        <p>{{ $vacante->DESCRIPCION }}</p>

                        <button type="button" class="btn btn-primary postularse-btn" data-bs-toggle="modal" data-bs-target="#postularseModal" data-vacante="{{ $slug }}">Postularse</button>
                    </div>
                @endforeach
            </div>
        
            
        </div>
    </div>


    <div class="modal fade" id="postularseModal" tabindex="-1" aria-labelledby="postularseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postularseModalLabel">Nota Importante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Para postularse asegúrese de estar registrado en el banco de CV. <br>
                    Si no está registrado o desea actualizar su CV, ingrese <a href="http://127.0.0.1:8001/Formulario-vacantes" target="_blank">aquí</a>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="notRegisteredBtn">No estoy registrado</button>
                    <button type="button" class="btn btn-success" id="registeredBtn">Sí estoy registrado</button>
                </div>
                <div class="modal-body" id="curpInputContainer" style="display:none;">
                    <div class="mb-3">
                        <label for="curpInput">Escribe tu CURP:</label>
                        <input type="text" id="curpInput" name="curp" class="form-control" placeholder="Escribe tu CURP aquí">
                    </div>
                </div>
                <div class="modal-footer" id="curpButtonsContainer" style="display:none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="submitCurpBtn">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetails(slug) {
            document.querySelectorAll('.details-pane').forEach(function(pane) {
                pane.classList.remove('active');
            });
            document.querySelectorAll('.list-group-item').forEach(function(link) {
                link.classList.remove('active-link');
            });

            document.getElementById('details-' + slug).classList.add('active');
            document.getElementById('link-' + slug).classList.add('active-link');
        }



        document.getElementById('notRegisteredBtn').addEventListener('click', function() {
        window.location.href = 'http://127.0.0.1:8001/Formulario-vacantes';
    });

    document.getElementById('registeredBtn').addEventListener('click', function() {
        document.getElementById('curpInputContainer').style.display = 'block';
        document.getElementById('curpButtonsContainer').style.display = 'block';
        document.querySelector('.modal-footer').style.display = 'none';
    });

    document.getElementById('submitCurpBtn').addEventListener('click', function() {
        // Lógica para enviar la CURP
    });

    </script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>

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
      
      <!-- Funciones generales -->
      <script src="/assets/js_sitio/funciones.js"></script>  
</body>
</html>