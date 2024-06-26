@extends('principal.maestra')

@section('contenido')


<style>

#mensaje {
            font-size: 0.9em;
            color: green;
        }
        
        #error {
            font-size: 0.9em;
            color: red;
        }

</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5 text-center" style="display: flex; justify-content: center; align-items: center; background-color: transparent;">
        <h3 style="color: #ffffff; margin: 0; display: flex; align-items: center;">
            <i class="bi bi-file-earmark-text" style="margin-right: 0.5rem;"></i> Banco de CV'S
        </h3>

        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_asesores" data-bs-toggle="modal" data-bs-target="#miModal_BANCOCV" style="margin-left: auto;">
            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>
    

    <div class="card-body">
        <table id="Tablabancocv" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal modal-fullscreen fade" id="miModal_BANCOCV" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
        <form method="post" enctype="multipart/form-data" id="formularioBANCO" style="background-color: #ffffff;">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Datos Personales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Seleccione la vacante:</label>
                                        <select class="form-control" id="VACANTES_POSTULACION" name="VACANTES_POSTULACION" required>
                                        <option selected disabled>Seleccione una opción</option>
                                        @foreach ($vacantes as $vacante)
                                            <option value="{{ $vacante->ID_CATALOGO_VACANTE }}">{{ $vacante->CATEGORIA_VACANTE }}</option>
                                        @endforeach
                                    </select>                          
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Nombre(s)</label>
                                    <input type="text" class="form-control" id="NOMBRE_CV" name="NOMBRE_CV" required>
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
                                    <input type="text" class="form-control" id="CORREO_CV" name="CORREO_CV" required>
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
                                        <label for="NUMERO1_CV" class="me-2">Teléfono 1</label>
                                    <input type="number" class="form-control col-auto" id="TELEFONO1" name="TELEFONO1" required>
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
                                        <label for="NUMERO1_CV" class="me-2">Teléfono 2</label>
                                    <input type="number" class="form-control col-auto" id="TELEFONO2" name="TELEFONO2" required>
                                    </div>                
                                </div>      
                               
                    
                                <div class="mb-3">
                                    <label>CURP</label>
                                    <input type="text" class="form-control" id="CURP_CV" name="CURP_CV" maxlength="18" required>
                                    <div id="contador" class="text-end"></div>
                                    <div id="mensaje"></div>
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
                                        <select class="form-select" id="ano" name="ANIO_FECHA_CV" id="ANIO_FECHA_CV" required>
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
                    
                                         
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success" id="guardarFormBancoCV">Guardar</button>
                                </div>
                                                                   
                            </form>
                        
                                                     
                    </div>
                </div>

        </form>
        </div>
    </div>
</div>






<div class="modal modal-fullscreen fade" id="miModal_VACANTES" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
        <form method="post" enctype="multipart/form-data" id="formularioBANCO" style="background-color: #ffffff;">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                        <div class="row">


                            <div class="mb-3">
                                <div class="form-group">
                                    <label>Seleccione la vacante:</label>
                                    <select class="form-control" id="VACANTES_POSTULACION" name="VACANTES_POSTULACION" required>
                                    <option selected disabled>Seleccione una opción</option>
                                    @foreach ($vacantes as $vacante)
                                        <option value="{{ $vacante->ID_CATALOGO_VACANTE }}">{{ $vacante->CATEGORIA_VACANTE }}</option>
                                    @endforeach
                                </select>                          
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group">
                                    <label>Nombre(s)</label>
                                    <input type="text" class="form-control" id="NOMBRE_CV" name="NOMBRE_CV" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">                            
                                    <label>Primero Apellido </label>
                                    <input type="text" class="form-control" id="PRIMER_APELLIDO_CV" name="PRIMER_APELLIDO_CV" required>
                                    </div>
                                </div>
                            </div>   
                                
                            <div class="row mb-3">
                                <div class="col-6">
                                   <label>Segundo Apellido </label>
                                   <input type="text" class="form-control" id="SEGUNDO_APELLIDO_CV" name="SEGUNDO_APELLIDO_CV" required>
                                </div>
                                <div class="col-6">
                                   <label>Correo</label>
                                   <input type="text" class="form-control" id="CORREO_CV" name="CORREO_CV" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label>Etiqueta</label>
                                    <select class="form-select" id="ETIQUETA_TELEFONO1" name="ETIQUETA_TELEFONO1" required>
                                        <option value="0" selected disabled></option>
                                        <option value="Móvil">Móvil</option>
                                        <option value="Trabajo">Trabajo</option>
                                        <option value="Principal">Principal</option>
                                        <option value="Casa">Casa</option>
                                    </select>
                                </div>
                                <div class="col-3">        
                                    <label for="NUMERO1_CV" class="me-2">Teléfono 1</label>
                                    <input type="number" class="form-control col-auto" id="TELEFONO1" name="TELEFONO1" required>
                                </div>
                                <div class="col-3">
                                    <label>Etiqueta</label>
                                    <select class="form-select" id="ETIQUETA_TELEFONO2" name="ETIQUETA_TELEFONO2" required>
                                        <option value="0" selected disabled></option>
                                        <option value="Móvil">Móvil</option>
                                        <option value="Trabajo">Trabajo</option>
                                        <option value="Principal">Principal</option>
                                        <option value="Casa">Casa</option>
                                    </select>
                                </div>
                                <div class="col-3">        
                                    <label for="NUMERO1_CV" class="me-2">Teléfono 2</label>
                                    <input type="number" class="form-control col-auto" id="TELEFONO2" name="TELEFONO2" required>
                                </div>                           
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                   <label>CURP</label>
                                   <input type="text" class="form-control" id="CURP_CV" name="CURP_CV" maxlength="18" required>
                                </div>
                            </div> 

                            <div class="row mb-3">
                                <label>Fecha de nacimiento</label>
                                    <div class="col-3">
                                        <label>Día</label>
                                        <select class="form-select"  id="dia" name="DIA_FECHA_CV" required>
                                            <option value="" selected disabled>Día</option>
                                        <!-- Genera los días del 1 al 31 -->
                                        <script>
                                        for (let i = 1; i <= 31; i++) {
                                            document.write('<option value="' + i + '">' + i + '</option>');
                                            }
                                            </script>
                                    </select>
                                </div>
                                <div class="col-3">   
                                    <label>Mes</label>
                                    <select class="form-select"  id="mes" name="MES_FECHA_CV" required>
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
                                </div>

                                <div class="col-3">
                                    <label>Año</label>
                                    <select class="form-select" id="ANIO_FECHA_CV" name="ANIO_FECHA_CV">
                                       
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label>Edad</label>
                                    <input type="text" class="form-control" id="EDAD" name="EDAD">
                                </div>
                            </div>

                            
                            <br>
                            <div class="row mb-3">
                                <div class="col-12">
                                <label class="text-center">Último grado académico cursado y terminado satisfactoriamente</label>
                                <select class="form-select" id="ULTIMO_GRADO_CV" name="ULTIMO_GRADO_CV" >
                                    <option value="0" selected disabled>Seleccione una opción</option>
                                    <option value="1">Primaria</option>
                                    <option value="2">Secundaria</option>
                                    <option value="3">Preparatoria</option>
                                    <option value="4">Licenciatura</option>
                                    <option value="5">Posgrado</option>
                                </select>
                                </div>                            
                           </div>

                            
                            <!-- Sección para Licenciatura -->
                            <div id="licenciatura-section" style="display: none;">
                                <div class="mb-3">
                                    <label>Nombre de la licenciatura</label>
                                    <input type="text" class="form-control" id="NOMBRE_LICENCIATURA_CV" name="NOMBRE_LICENCIATURA_CV">
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">¿Cuenta con Título?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="titulo-licenciatura-si">Si</label>
                                            <input class="form-check-input" type="radio" name="CUENTA_TITULO_LICENCIATURA_CV" id="titulo-licenciatura-si" value="Si">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="titulo-licenciatura-no">No</label>
                                            <input class="form-check-input" type="radio" name="CUENTA_TITULO_LICENCIATURA_CV" id="titulo-licenciatura-no" value="No">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">¿Cuenta con Cédula profesional?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="cedula-licenciatura-si">Si</label>
                                            <input class="form-check-input" type="radio" name="CEDULA_TITULO_LICENCIATURA_CV" id="cedula-licenciatura-si" value="Si">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="cedula-licenciatura-no">No</label>
                                            <input class="form-check-input" type="radio" name="CEDULA_TITULO_LICENCIATURA_CV" id="cedula-licenciatura-no" value="No">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sección para Posgrado -->
                            <div id="posgrado-section" style="display: none;">
                                <div class="mb-3">
                                    <label>Tipo de posgrado</label>
                                    <select class="form-select" id="TIPO_POSGRADO_CV" name="TIPO_POSGRADO_CV">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value="1">Especialidad</option>
                                        <option value="2">Maestría</option>
                                        <option value="3">Doctorado</option>
                                        <option value="4">Post Doctorado</option>
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label>Nombre del posgrado</label>
                                    <input type="text" class="form-control" id="NOMBRE_POSGRADO_CV" name="NOMBRE_POSGRADO_CV">
                                </div>
                                <div class="mb-3">
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
                                <div class="mb-3">
                                    <label class="col-form-label">¿Cuenta con Cédula profesional?</label>
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
                    </div>
                </div>
         </form>
        </div>
    </div>
</div>




















<!-- Modal para mostrar PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" src="" frameborder="0" style="width: 100%; height: 80vh;"></iframe>
            </div>
        </div>
    </div>
</div>




@endsection