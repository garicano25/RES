<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


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
  
  
      <!--Archivo css -->
      <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    



    <style>
        .header {
            background-color: rgb(255, 255, 255); 
            padding: 20px;
            display: flex;
            align-items: center; 
            justify-content: space-between; 
            -webkit-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); 
            -moz-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); 
            box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); 
        }
    
        .logo-img {
            width: 150px;
            margin-right: 15px; 
        }
    
        .header-text {
            flex: 1; 
            display: flex;
            align-items: center; 
            justify-content: center; 
        }
    
        h1 {
            margin: 0;
            color: rgb(0, 0, 0); 
            font-family: Poppins;
    
        }
        .form-label-puestos {
            font-family: Poppins;
    
        font-size: 1.5rem; 
        e fuente más grande 
        margin: auto;
        text-align: center;
        display: block; 
        width: fit-content; 
    }   
    </style>
    
    <header class="header mt-5 mb-4">
        <img src="/assets/images/Negroancho.png" alt="Logo" class="logo-img"> 
        <div class="header-text">
            <h1>Vacantes</h1> 
        </div>
    </header>
     
    
    
    <div class="contenedor-contenido">
        <form id="formulario">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control"  name="NOMBRE_VACANTE"    id="NOMBRE_VACANTE" placeholder="Nombre completo" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="CORREO_VACANTE" id="CORREO_VACANTE" placeholder="correo@example.com" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="number" class="form-control"  name="TELEFONO_VACANTE" id="TELEFONO_VACANTE" placeholder="Teléfono" required>
            </div>
            <div class="mb-3">
                <label for="curp" class="form-label">CURP</label>
                <input type="text" class="form-control" name="CURP_VACANTE"  id="CURP_VACANTE" placeholder="CURP" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="FECHA_NACIMIENTO_VACANTE"  id="FECHA_NACIMIENTO_VACANTE"  required> 
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" name="EDAD_VACANTE" class="form-control" id="EDAD_VACANTE"  required>
            </div>
            
            <button type="button" class="btn btn-danger" id="btnSiguiente">Siguiente</button>
            
            <br><br>
    
    
            <div class="mb-3 d-none" id="selectPuestos">
                <label for="puestos" class="form-label form-label-puestos">Vacantes</label>
                <select class="form-select"  name="PUESTO_VACANTES" id="PUESTO_VACANTES" required>
                    <option selected disabled>Selecciona un puesto</option>
                    <option value="1">Asistente RRHH</option>
                    <option value="2">Asistente de planeación y logística</option>
                    <option value="3">Intendente</option>
                    <option value="4">Asistente contable</option>
                    <option value="5">Asistente de nómina</option>
                    <option value="6">Asistente de compras</option>
                    <option value="7">Almacenista</option>
                    <option value="8">Consultor</option>
                    <option value="9">Instructor - Facilitador</option>
                    <option value="10">Ejecutivo de ventas</option>
                    <option value="11">Desarrollador de Software</option>
    
                </select>
            </div>
                
            </div>
        </form>
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
    <!-- Funciones generales -->
    <script src="/assets/js_sitio/funciones.js"></script>
    <!-- Select opcion selectize -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>



</body>
</html>





