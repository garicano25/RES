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
            margin-bottom: 10px; /* Adds space between list items */
            border: 1px solid #dee2e6;
            border-radius: 10px; /* Makes borders rounded */
            padding: 15px; /* Adds padding inside the list items */
        }

        .list-group-item.active-link {
            border-color: #007bff;
            background-color: #f0f8ff;
            border-radius: 10px; /* Keeps borders rounded when active */
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
            margin-top: 10px; /* Space between the top of the container and the card */
            border-radius: 10px; /* Makes borders rounded */
        }

        .details-pane.active {
            display: block;
            border-color: #007bff;
            border-radius: 10px; /* Keeps borders rounded when active */
        }

        .details-pane p {
            white-space: pre-wrap; /* Makes sure the text wraps inside the card */
            word-wrap: break-word; /* Ensures long words break correctly */
            font-size: 1rem; /* Ensures all text is the same size */
            line-height: 1.5; /* Improves readability */
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 100%;
            height: auto; */
        } */
    </style>
  
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; background-image: url(/assets/images/Logo3.png); background-size: cover;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">
            </a>
            
        </div>
    </nav>




    <div class="container mt-5">
        <h2 class="text-center"><b>¡ESTAS SON NUESTRAS VACANTES DISPONIBLES!</b></h2>
        <br><br>


        <div class="row">

            <div class="col-md-4">
                <div class="list-group">
                    @foreach($vacantes as $vacante)
                        @php
                            $slug = \Illuminate\Support\Str::slug($vacante->CATEGORIA_VACANTE);
                        @endphp
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="showDetails('{{ $slug }}')" id="link-{{ $slug }}">
                            <h5 class="mb-1">{{ $vacante->CATEGORIA_VACANTE }}</h5>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-8 position-relative">
                @foreach($vacantes as $vacante)
                    @php
                        $slug = \Illuminate\Support\Str::slug($vacante->CATEGORIA_VACANTE);
                    @endphp
                    <div class="details-pane" id="details-{{ $slug }}">
                        <h5 class="card-title">{{ $vacante->CATEGORIA_VACANTE }}</h5>
                        <hr>
                        <p>{{ $vacante->DESCRIPCION_VACANTE }}</p>
                        <p><strong>Requisitos:</strong></p>
                        <p>{{ $vacante->REQUISITOS_VACANTES }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function showDetails(slug) {
            // Hide all details panes and remove active class from links
            document.querySelectorAll('.details-pane').forEach(function(pane) {
                pane.classList.remove('active');
            });
            document.querySelectorAll('.list-group-item').forEach(function(link) {
                link.classList.remove('active-link');
            });

            // Show the selected details pane and add active class to the clicked link
            document.getElementById('details-' + slug).classList.add('active');
            document.getElementById('link-' + slug).classList.add('active-link');
        }
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