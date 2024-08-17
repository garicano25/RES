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
    

    
body {
    font-family: 'Poppins', sans-serif;
}
    #details-container {
    width: 100%;
    display: flex;
    justify-content: center;
}

.details-pane {
    width: 80%; 
    max-width: 1300px; 
    margin: 0 auto; 
    padding: 20px;
    background-color: #fff; 
    border-radius: 10px; 
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); 
}

#tabla-vacantes {
    width: 113% !important;
    max-width: none;
    margin: 0 auto;
    display: table; /* Asegura que se comporte como tabla */

}


#tabla-vacantes {
    border-collapse: collapse;
    width: 100%;
}

#tabla-vacantes th, #tabla-vacantes td {
    border-bottom: 1px solid #ccc;  /* Línea gris entre celdas */
    text-align: left;
    padding: 10px;  /* Espaciado dentro de las celdas */
}

#tabla-vacantes th {
    border-bottom: 2px solid #ccc;  /* Línea más gruesa en el encabezado */
    font-weight: bold;
}

#tabla-vacantes td {
    background-color: transparent;  /* Sin fondo en las celdas */
}







a:hover {
    text-decoration: underline;
}



.
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
        <div class="col-md-12">
            <table class="table table-borderless" id="tabla-vacantes">
                <thead>
                    <tr>
                        <th>Vacantes</th>
                        <th>Lugar de trabajo</th>
                        <th>Fecha de publicación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vacantes as $vacante)
                    @php
                        $slug = \Illuminate\Support\Str::slug($vacante->CATEGORIA_VACANTE);
                        $fechaFormateada = Carbon::parse($vacante->created_at)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
                    @endphp
                    <tr>
                        <td><a href="javascript:void(0)" onclick="showDetails('{{ $slug }}')">{{ $vacante->CATEGORIA_VACANTE }}</a></td>
                        <td>{{ $vacante->LUGAR_VACANTE }}</td>
                        <td>{{ $fechaFormateada }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
            

            
            <div class="col-md-8 position-relative mx-auto" id="details-container">
                @foreach($vacantes as $vacante)
                    @php
                        $slug = \Illuminate\Support\Str::slug($vacante->CATEGORIA_VACANTE);
                        $fechaFormateada = Carbon::parse($vacante->created_at)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
                    @endphp
                    <div class="details-pane card" id="details-{{ $slug }}" style="display: none; width: 80%; max-width: 1100px; margin: 0 auto;">
                        
                        <!-- Enlace para regresar a la tabla -->
                        <div class="text-start mb-3">
                            <a href="#" onclick="volverATabla()" style="color: red; text-decoration: none;">
                                <span style="font-size: 1.2em; font-weight: bold;">&#x2190;</span> Volver a los resultados de búsqueda
                            </a>
                        </div>
            
                        <!-- Contenido de la card -->
                        <h5 class="card-title text-center">{{ $vacante->CATEGORIA_VACANTE }}</h5> <br>
                        <label><b>Lugar de trabajo:</b> </label>
                        <label>{{ $vacante->LUGAR_VACANTE }}</label> <br>
                        <label><b>Fecha de publicación:</b></label>
                        <label class="mb-1">{{ $fechaFormateada }}</label>
                        <hr>
                        <p><strong>Descripción:</strong></p>
                        <p>{{ $vacante->DESCRIPCION_VACANTE }}</p>
                        <p><strong>Requisitos:</strong></p>
                        <ul>
                            @foreach($vacante->requerimientos as $requerimiento)
                                <li>{{ $requerimiento }}</li>
                            @endforeach
                        </ul>

                        
                        <!-- Botón para postularse -->
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



<!-- ============================================================== -->
<!-- SCRIPT -->
<!-- ============================================================== -->


<script>
       
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



function showDetails(slug) {
    document.querySelector('.table').style.display = 'none';
    
    var detailsPanes = document.querySelectorAll('.details-pane');
    detailsPanes.forEach(function(pane) {
        pane.style.display = 'none';  
    });

    
    document.getElementById('details-' + slug).style.display = 'block';  
}


function volverATabla() {
    document.querySelectorAll('.details-pane').forEach(function(panel) {
        panel.style.display = 'none';
    });

    var tablaVacantes = document.getElementById('tabla-vacantes');
    if (tablaVacantes) {
        tablaVacantes.style.display = 'table';
        tablaVacantes.classList.add('table', 'table-responsive');  // Añade clases si es necesario
    } else {
        console.error('No se encontró el elemento con id "tabla-vacantes". Asegúrate de que existe.');
    }
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
<!-- ============================================================== -->
<!-- SCRIPT -->
<!-- ============================================================== -->

</body>
</html>