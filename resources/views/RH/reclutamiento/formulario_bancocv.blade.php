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
      <!--Archivo css -->
      <link rel="stylesheet" href="assets/css/estilos.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> 
</head>
<body>
    

    <style>

            body {
            font-family: 'Poppins', sans-serif;
            /* background-color: #007DBA; */
        }
        .card {
        max-width: 800px; 
        margin: 20px auto; 
        border: 2px solid #007DBA; 
        /* min-height: 500px;  */
}
        .card-img-top {
            display: block;
            margin: 0 auto;
            width: 50%; 
            height: auto; 
        }


        #ID_BANCO_CURP_CV {
         text-transform: uppercase;
    }


        #contador {
            font-size: 12px;
            color: gray; /* Color del contador */
        }

        /* #mensaje {
            margin-top: 5px;
            color: red;  
        } */
   

        #mensaje {
            font-size: 0.9em;
            color: green;
        }
        
        #error {
            font-size: 0.9em;
            color: red;
        }

       

        .modal-header img {
            position: absolute;
            right: 10px;
            top: 10px;
            max-height: 50px;
        }

        .modal-footer {
            justify-content: center;
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(16, 16, 16, 0.958);
        }

        .modal-body {
            font-size: 1rem;
        }

        .modal-backdrop.show {
            opacity: 1;
        }

        .modal-backdrop {
            background-color: rgba(16, 16, 16, 0.963); /* Fondo completamente opaco */
        }
        .btn-light.btn-sm {
    background-color: white;
    color: black;
    border: 1px solid #ced4da;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    }

    .btn-light.btn-sm:hover {
        background-color: #e2e6ea;
    }

    .text-danger {
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .add-button {
                padding: 5px 10px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .add-button i {
                margin-right: 5px;
            }

            .small-checkbox {
    width: 20px;
    height: 20px;
}



    </style>



</head>
<body>

  
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; background-image: url(/assets/images/Logo3.png); background-size: cover;">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://www.results-in-performance.com/">
                <img src="/assets/images/rip_logoblanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">
                {{-- <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo"> --}}

            </a>
            
        </div>
    </nav>



<div class="card">
    <img src="/assets/images/rip_logocolores.png" class="card-img-top" alt="Imagen superior">

    {{-- <img src="/assets/images/Colorancho.png" class="card-img-top" alt="Imagen superior"> --}}
    <div class="card-body">
        <form method="post"  enctype="multipart/form-data" id="formularioBANCO">   
            {!! csrf_field() !!}
            
            <div class="mb-3">
                <input type="hidden" class="form-control" id="AVISO_PRIVACIDAD" name="AVISO_PRIVACIDAD" value="1">
            </div>
            <div class="mb-3">
                <label>Nombre(s)</label>
                <input type="text" class="form-control" id="NOMBRE_CV" name="NOMBRE_CV" required>
            </div>
            <div class="mb-3">
                <label>Primero Apellido </label>
                <input type="text" class="form-control" id="PRIMER_APELLIDO_CV" name="PRIMER_APELLIDO_CV" required>
            </div>
            <div class="mb-3">
                <label>Segundo Apellido </label>
                <input type="text" class="form-control" id="SEGUNDO_APELLIDO_CV" name="SEGUNDO_APELLIDO_CV" required>
            </div>
          
            <div class="mb-3">
                <label>Correo</label>
                <input type="email" class="form-control" id="CORREO_CV" name="CORREO_CV" required>
            </div>
          
         

            <div class="mb-3 d-flex align-items-center">

                <div class="col-2">
                    <label>Etiqueta</label>
                    <select class="form-select" id="ETIQUETA_TELEFONO1" name="ETIQUETA_TELEFONO1" required>
                        <option value="0" selected disabled></option>
                        <option value="Móvil">Móvil</option>
                        <option value="Trabajo">Trabajo</option>
                        <option value="Principal">Principal</option>
                        <option value="Casa">Casa</option>
                    </select>
                </div>
                <div class="col-10 mx-2">        
                    <label class="me-2">Teléfono 1</label>
                <input type="number" class="form-control col-auto" id="TELEFONO1" name="TELEFONO1" maxlength="10" required>
                </div>
                
            </div>
            

            <div class="mb-3 d-flex align-items-center">

                <div class="col-2">
                    <label>Etiqueta</label>
                    <select class="form-select" id="ETIQUETA_TELEFONO2" name="ETIQUETA_TELEFONO2" required>
                        <option value="0" selected disabled></option>
                        <option value="Móvil">Móvil</option>
                        <option value="Trabajo">Trabajo</option>
                        <option value="Principal">Principal</option>
                        <option value="Casa">Casa</option>
                    </select>
                </div>
                <div class="col-10 mx-2">        
                    <label class="me-2">Teléfono 2</label>
                <input type="number" class="form-control col-auto" id="TELEFONO2" name="TELEFONO2"  maxlength="10" required>
                </div>                
            </div>      
           

            <div class="mb-3">
                <label>CURP</label>
                <input type="text" class="form-control" id="CURP_CV" name="CURP_CV" maxlength="18" required>
                <div id="contador" class="text-end">0/18</div>
                <div id="mensaje"></div>
                <div id="error"></div>
            </div> 
            <div class="mb-3">
                <label>Género</label>
                <select class="form-control" id="GENERO" name="GENERO" required>
                    <option selected disabled>Seleccione una opción</option>
                    @foreach ($generos as $genero)
                        <option value="{{ $genero->ID_CATALOGO_GENERO }}">{{ $genero->NOMBRE_GENERO }}</option>
                    @endforeach
                </select> 
            </div> 


            <div class="mb-3">
                <label>Fecha de nacimiento</label>
                <div class="d-flex justify-content-between">
                    <select class="form-select me-2" id="dia" name="DIA_FECHA_CV" required>
                        <option value="" selected disabled>Día</option>
                        <!-- Genera los días del 1 al 31 -->
                        <script>
                            for (let i = 1; i <= 31; i++) {
                                document.write('<option value="' + i + '">' + i + '</option>');
                            }
                        </script>
                    </select>
                    <select class="form-select me-2" id="mes" name="MES_FECHA_CV" required>
                        <option value="" selected disabled>Mes</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                    <select class="form-select" id="ano" name="ANIO_FECHA_CV" required>
                        <option value="" selected disabled>Año</option>
                        <!-- Genera los años desde 1900 hasta el año actual -->
                        <script>
                            const currentYear = new Date().getFullYear();
                            for (let i = currentYear; i >= 1900; i--) {
                                document.write('<option value="' + i + '">' + i + '</option>');
                            }
                        </script>
                    </select>
                </div>
            </div>
            <br>
            <div class="mb-3">
            <labe class="text-center">Último grado académico cursado y terminado satisfactoriamente</labe>
            </div>
            <div class="mb-3">
                <select class="form-select" id="ULTIMO_GRADO_CV" name="ULTIMO_GRADO_CV" required>
                    <option value="0" selected disabled>Seleccione una opción</option>
                    <option value="1">Primaria</option>
                    <option value="2">Secundaria</option>
                    <option value="3">Preparatoria</option>
                    <option value="4">Licenciatura</option>
                    <option value="5">Posgrado</option>
                </select>
            </div>
            <div class="mb-3" id="licenciatura-nombre-container" style="display: none;">
                <label>Nombre de la licenciatura</label>
                <input type="text" class="form-control" id="NOMBRE_LICENCIATURA_CV" name="NOMBRE_LICENCIATURA_CV">
            </div>
    


            <div class="mb-3" id="licenciatura-titulo-container" style="display: none;">
                <label class="col-form-label">¿Cuenta con Título?</label>
                <div class="d-flex">
                    <div class="form-check me-3">
                        <label class="form-check-label" for="si">Si</label>
                        <input class="form-check-input" type="radio" name="CUENTA_TITULO_LICENCIATURA_CV" id="si" value="Si" >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="no">No</label>
                        <input class="form-check-input" type="radio" name="CUENTA_TITULO_LICENCIATURA_CV" id="no" value="NO" >
                    </div>
                </div>
            </div>

            <div class="mb-3" id="licenciatura-cedula-container" style="display: none;">
                <label class="col-form-label">¿Cuenta con cédula profesional?</label>
                <div class="d-flex">
                    <div class="form-check me-3">
                        <label class="form-check-label" for="si">Si</label>
                        <input class="form-check-input" type="radio" name="CEDULA_TITULO_LICENCIATURA_CV" id="si" value="Si" >
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="no">No</label>
                        <input class="form-check-input" type="radio" name="CEDULA_TITULO_LICENCIATURA_CV" id="no" value="NO" >
                    </div>
                </div>
            </div>


            <div class="mb-3" id="posgrado-container" style="display: none;">
                <label>Tipo de posgrado</label>
                <select class="form-select" id="TIPO_POSGRADO_CV" name="TIPO_POSGRADO_CV">
                    <option value="0" selected disabled>Seleccione una opción</option>
                    <option value="1">Especialidad</option>
                    <option value="2">Maestría</option>
                    <option value="3">Doctorado</option>
                    <option value="4">Post Doctorado</option>
                </select>
                <div class="mt-3" id="posgrado-nombre-container" style="display: none;">
                    <label>Nombre del posgrado</label>
                    <input type="text" class="form-control" id="NOMBRE_POSGRADO_CV" name="NOMBRE_POSGRADO_CV">
                </div>
                <div class="mb-3" id="posgrado-titulo-container" style="display: none;">
                    <label class="col-form-label">¿Cuenta con Título?</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <label class="form-check-label" for="titulo-posgrado-si">Si</label>
                            <input class="form-check-input" type="radio" name="CUENTA_TITULO_POSGRADO_CV" id="titulo-posgrado-si" value="Si">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="titulo-posgrado-no">No</label>
                            <input class="form-check-input" type="radio" name="CUENTA_TITULO_POSGRADO_CV" id="titulo-posgrado-no" value="No">
                        </div>
                    </div>
                </div>
                <div class="mb-3" id="posgrado-cedula-container" style="display: none;">
                    <label class="col-form-label">¿Cuenta con cédula profesional?</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <label class="form-check-label" for="cedula-posgrado-si">Si</label>
                            <input class="form-check-input" type="radio" name="CEDULA_TITULO_POSGRADO_CV" id="cedula-posgrado-si" value="Si">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="cedula-posgrado-no">No</label>
                            <input class="form-check-input" type="radio" name="CEDULA_TITULO_POSGRADO_CV" id="cedula-posgrado-no" value="No">
                        </div>
                    </div>
                </div>
            </div>
            


            <div class="mb-3 text-center">
                <label class="mt-4"> Áreas de interés</label>
            </div>

            <div class="mb-3 d-flex">
                <div class="col-6 me-1 text-center">
                    <label>Administrativas</label>
                    <select class="form-select" id="INTERES_ADMINISTRATIVA" name="INTERES_ADMINISTRATIVA[]" multiple>
                       <option selected disabled></option>
                        @foreach ($administrativas as $administrativa)
                            <option value="{{ $administrativa->ID_CATALOGO_AREAINTERES }}">{{ $administrativa->NOMBRE_AREA }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-6 text-center">
                    <label>Operativas</label>
                    <select class="form-select" id="INTERES_OPERATIVAS" name="INTERES_OPERATIVAS[]"  multiple>
                       <option selected disabled></option>
                        
                        @foreach ($operativas as $operativa)
                        <option value="{{ $operativa->ID_CATALOGO_AREAINTERES }}">{{ $operativa->NOMBRE_AREA }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            


            <div class="mb-3 text-center">
                <label class="mt-4">Documentos</label>
            </div>
            <div class="mb-3">
                <label class="mt-4"><b>Cargar archivos en PDF (Máximo 2&nbsp;MB)</b></label>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label>CURP. &nbsp;</label>
                <input type="file" class="form-control" id="ARCHIVO_CURP_CV" name="ARCHIVO_CURP_CV" accept=".pdf" style="width: auto; flex: 1;" required>
                <button type="button" class="btn btn-light btn-sm ms-2" id="quitarCURP" style="display:none;">Quitar archivo</button>
            </div>
            <div id="CURP_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

            <div class="mb-3 d-flex align-items-center">
                <label>CV. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="file" class="form-control" id="ARCHIVO_CV" name="ARCHIVO_CV" accept=".pdf" style="width: auto; flex: 1;" required>
                <button type="button" class="btn btn-light btn-sm ms-2" id="quitarCV" style="display:none;">Quitar archivo</button>
            </div>
            <div id="CV_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                     
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input small-checkbox" id="aceptaTerminos">
                <label class="form-check-label" for="aceptaTerminos">He aceptado los términos y condiciones del aviso de privacidad de Results In Performance</label>
            </div>
            <button type="submit" class="btn btn-success" id="guardarFormBancoCV" disabled>Guardar</button>           
        </form>
    </div>
</div>
    


    <!-- Modal de Aviso de Privacidad -->
<div class="modal fade" id="avisoPrivacidadModal" tabindex="-1" aria-labelledby="avisoPrivacidadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avisoPrivacidadModalLabel">Aviso de Privacidad</h5>
                <img src="/assets/images/rip_logocolores.png" alt="Imagen de Privacidad">                    
                {{-- <img src="/assets/images/Colorancho.png" alt="Imagen de Privacidad"> --}}
            </div>
            <div class="modal-body">
                <p><b>“RESULTS”</b> trata datos sensibles los cuales se utilizan para la contratación de
                    colaboradores, envío de cotizaciones, asignación de órdenes de trabajo o de
                    compra, completar diversos formatos y para generar los informes de consultoría.
                    Los datos que utilizaremos para las finalidades descritas en el presente aviso de
                    privacidad son los siguientes: <br><br>

                    <b> Para prospecto a colaboradores:</b><br>
                    -Nombre completo<br>
                    -CURP<br>
                    -Currículo Vitae<br>
                    -Teléfono celular<br>
                    -Correo electrónico
                </p>
                <p ><b>Nota:</b> Si desea consultar el aviso de privacidad completo y los derechos de ARCO,
                    entre a nuestra página web <a href="http://results-in-performance.com" target="_blank">aquí</a>.</p>

                <p class="text-center">Aceptar términos</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="aceptoTerminos">Sí</button>
                <button type="button" class="btn btn-secondary" id="noAceptoTerminos">No</button>
            </div>
        </div>
    </div>
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

     <!-- Funciones generales -->
     <script src="/assets/js_sitio/funciones.js"></script>
    <script src="/assets/js_sitio/reclutamiento/banco_cv.js"></script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    
    


</body>
</html>




