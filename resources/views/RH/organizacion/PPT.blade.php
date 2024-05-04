@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 10px; border-radius: 10px;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-filetype-ppt"></i> PPT</h3>
          <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_ppt" data-bs-toggle="modal" data-bs-target="#miModal" style="margin-left: auto;">
    Nuevo PPT  <i class="bi bi-plus-circle"></i> 
  </button>
 </ol>
  

   </div>

   


<!-- MODAL  -->
<div class="modal modal-fullscreen fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel" >Perfil del puesto de trabajo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="row mb-3">
                <div class="col-4">
                    <div class="form-group">
                        <label>Nombre del puesto</label>
                        <input type="text" class="form-control" id="NOMBRE_PUESTO_PPT" name="NOMBRE_PUESTO_PPT">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Nombre del trabajador</label>
                        <input type="text" class="form-control" id="NOMBRE_TRABAJADOR_PPT" name="NOMBRE_TRABAJADOR_PPT">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Área de trabajador</label>
                        <input type="text" class="form-control" id="AREA_TRABAJADO_PPT" name="AREA_TRABAJADO_PPT">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label>Propósito o finalidad del puesto</label>
                        <textarea class="form-control" id="AREA_TRABAJADO_PPT" name="AREA_TRABAJADO_PPT" rows="3"></textarea>
                    </div>
                </div>
            </div>
                <!-- I. Características generales -->
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h4>I. Características generales</h4>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-5">
                    <div class="form-group">
                        <label>Edad (mínima / máxima)</label>
                        <select class="form-control" id="EDAD_PPT" name="EDAD_PPT">
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1">Indistinto</option>
                            <option value="2">18-25</option>
                            <option value="3">26-35</option>
                            <option value="4">36-45</option>
                            <option value="5">Mayor de 45</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <label>Lo cumple</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="EDAD_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="EDAD_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label>Género</label>
                        <select class="form-control" id="GENERO_PPT" name="GENERO_PPT">
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1">Indistinto</option>
                            <option value="2">Masculino</option>
                            <option value="3">Femenino</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <label>Lo cumple</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="GENERO_CUMPLE_PPT" id="GENERO_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="GENERO_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="GENERO_CUMPLE_PPT" id="GENERO_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="GENERO_CUMPLE_NO">No</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-5">
                    <div class="form-group">
                        <label>Estado civil</label>
                        <select class="form-control" id="ESTADO_CIVIL_PPT" name="ESTADO_CIVIL_PPT">
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1">Indistinto</option>
                            <option value="2">Soltero (a)</option>
                            <option value="3">Casado (a)</option>
                            <option value="4">Separado (a)</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <label>Lo cumple</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="ESTADO_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="ESTADO_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label>Nacionalidad </label>
                        <select class="form-control" id="NACIONALIDAD_PPT" name="NACIONALIDAD_PPT">
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1">Indistinto</option>
                            <option value="2">Mexicana</option>
                            <option value="3">Extranjero</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <label>Lo cumple</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="NACIONALIDAD_CUMPLE_PPT" id="NACIONALIDAD_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="NACIONALIDAD_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="NACIONALIDAD_CUMPLE_PPT" id="NACIONALIDAD_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="NACIONALIDAD_CUMPLE_NO">No</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-5">
                    <div class="form-group">
                        <label>Persona con discapacidad</label>
                        <select class="form-control" id="DISCAPACIDAD_PPT" name="DISCAPACIDAD_PPT">
                            <option selected disabled>Seleccione una opción</option>
                            <option value="1">Indistinto</option>
                            <option value="2">Ninguna</option>
                            <option value="3">Motriz</option>
                            <option value="4">Visual </option>
                            <option value="5">Auditiva</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <label>Lo cumple</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DISCAPACIDAD_CUMPLE_PPT" id="DISCAPACIDADCUMPLE_SI" value="si">
                        <label class="form-check-label" for="DISCAPACIDAD_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="DISCAPACIDAD_CUMPLE_PPT" id="DISCAPACIDAD_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="DISCAPACIDAD_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>¿Cuál?</label>
                        <input type="text" class="form-control" id="CUAL_PPT" name="CUAL_PPT">
                    </div>
                </div>
            </div>

            <!-- II. Formación académica -->
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h4>II. Formación académica</h4>
                </div>
            </div>
            <div class="row mb-3">
                {{-- Area de escuela --}}
                <div class="col-4">
                    <div class="row">
                        <!-- SECUNDARIA -->
                        <div class="col-12"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Secundaria</label>
                                        <select class="form-control" id="SECUNDARIA_PPT" name="SECUNDARIA_PPT">
                                            <option selected disabled>Seleccione una opción</option>
                                            <option value="1">Incompleta</option>
                                            <option value="2">Completa</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                     <label>Lo cumple</label><br>
                                     <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" name="SECUNDARIA_CUMPLE_PPT" id="SECUNDARIA_CUMPLE_SI" value="si">
                                         <label class="form-check-label" for="SECUNDARIA_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="SECUNDARIA_CUMPLE_PPT" id="SECUNDARIA_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="SECUNDARIA_CUMPLE_NO">No</label>
                                        </div>
                                </div>
                            </div> 
                        </div>
                         <!-- TECNICA BASICA -->
                         <div class="col-12"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Técnica básica</label>
                                        <select class="form-control" id="TECNICA_PPT" name="TECNICA_PPT">
                                            <option selected disabled>Seleccione una opción</option>
                                            <option value="1">Incompleta</option>
                                            <option value="2">Completa</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                     <label>Lo cumple</label><br>
                                     <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" name="TECNICA_CUMPLE_PPT" id="TECNICA_CUMPLE_SI" value="si">
                                         <label class="form-check-label" for="TECNICA_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="TECNICA_CUMPLE_PPT" id="TECNICA_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="TECNICA_CUMPLE_NO">No</label>
                                        </div>
                                </div>
                            </div> 
                        </div>
                         <!-- TECNICO SUPERIOR -->
                         <div class="col-12"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Técnico superior</label>
                                        <select class="form-control" id="TECNICO_PPT" name="TECNICO_PPT">
                                            <option selected disabled>Seleccione una opción</option>
                                            <option value="1">Incompleta</option>
                                            <option value="2">Completa</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                     <label>Lo cumple</label><br>
                                     <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" name="TECNICO_CUMPLE_PPT" id="TECNICO_CUMPLE_SI" value="si">
                                         <label class="form-check-label" for="TECNICO_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="TECNICO_CUMPLE_PPT" id="TECNICO_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="TECNICO_CUMPLE_NO">No</label>
                                        </div>
                                </div>
                            </div> 
                        </div>
                        <!-- UNIVERSITARIO -->
                        <div class="col-12"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Universitario (Lic.)</label>
                                        <select class="form-control" id="UNIVERSITARIO_PPT" name="UNIVERSITARIO_PPT">
                                            <option selected disabled>Seleccione una opción</option>
                                            <option value="1">Incompleta</option>
                                            <option value="2">Completa</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                     <label>Lo cumple</label><br>
                                     <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" name="UNIVERSITARIO_CUMPLE_PPT" id="UNIVERSITARIO_CUMPLE_SI" value="si">
                                         <label class="form-check-label" for="UNIVERSITARIO_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="UNIVERSITARIO_CUMPLE_PPT" id="UNIVERSITARIO_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="UNIVERSITARIO_CUMPLE_NO">No</label>
                                        </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                {{-- Situación académica   --}}
                <div class="col-4">
                    <div class="row">
                        <!-- SECUNDARIA -->
                        <div class="col-12 mb-5" > 
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Situación académica </label>
                                        <select class="form-control" id="SITUACION_PPT" name="SITUACION_PPT">
                                            <option selected disabled>Seleccione una opción</option>
                                            <option value="1">Egresado</option>
                                            <option value="2">Bachiller</option>
                                            <option value="3">Titulado</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                     <label>Lo cumple</label><br>
                                     <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" name="SITUACION_CUMPLE_PPT" id="SITUACION_CUMPLE_SI" value="si">
                                         <label class="form-check-label" for="SITUACION_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="SITUACION_CUMPLE_PPT" id="SITUACION_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="SITUACION_CUMPLE_NO">No</label>
                                        </div>
                                </div>
                            </div> 
                        </div>
                        <!--Cédula profesional  -->
                        <div class="col-12 mt-5"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Cédula profesional</label>
                                        <select class="form-control" id="CEDULA_PPT" name="CEDULA_PPT">
                                            <option selected disabled>Seleccione una opción</option>
                                            <option value="1">Aplica</option>
                                            <option value="2">No aplica</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                     <label>Lo cumple</label><br>
                                     <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" name="CEDULA_CUMPLE_PPT" id="CEDULA_CUMPLE_SI" value="si">
                                         <label class="form-check-label" for="CEDULA_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="CEDULA_CUMPLE_PPT" id="CEDULA_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="CEDULA_CUMPLE_NO">No</label>
                                        </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                    {{-- Áreas de conocimientos --}}
                    <div class="col-4">
                        <div class="row">
                            <div class="col-12"> 
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label>Áreas de conocimientos</label>
                                            <select class="form-control" id="AREA1_PPT" name="AREA1_PPT">
                                                <option selected disabled>Seleccione una opción</option>
                                                <option value="1">N/A</option>
                                                <option value="2">Agronomía</option>
                                                <option value="3">C. Educación</option>
                                                <option value="4">C. Naturales</option>
                                                <option value="5">C. Salud</option>
                                                <option value="6">C. Sociales</option>
                                                <option value="7">Administración </option>
                                                <option value="8">Ingeniería</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Lo cumple</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="AREA1_CUMPLE_PPT" id="AREA1_CUMPLE_SI" value="si">
                                            <label class="form-check-label" for="AREA1_CUMPLE_SI">Si</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="AREA1_CUMPLE_PPT" id="AREA1_CUMPLE_NO" value="no">
                                                <label class="form-check-label" for="AREA1_CUMPLE_NO">No</label>
                                            </div>
                                    </div>
                                </div> 
                            </div>
                            <!-- AREA 2 -->
                            <div class="col-12 mt-3"> 
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <select class="form-control" id="AREA2_PPT" name="AREA2_PPT">
                                                <option selected disabled>Seleccione una opción</option>

                                                <option value="1">N/A</option>
                                                <option value="2">Agronomía</option>
                                                <option value="3">C. Educación</option>
                                                <option value="4">C. Naturales</option>
                                                <option value="5">C. Salud</option>
                                                <option value="6">C. Sociales</option>
                                                <option value="7">Administración </option>
                                                <option value="8">Ingeniería</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Lo cumple</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="AREA2_CUMPLE_PPT" id="AREA2_CUMPLE_SI" value="si">
                                            <label class="form-check-label" for="AREA2_CUMPLE_SI">Si</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="AREA2_CUMPLE_PPT" id="AREA2_CUMPLE_NO" value="no">
                                                <label class="form-check-label" for="AREA2_CUMPLE_NO">No</label>
                                            </div>
                                    </div>
                                </div> 
                            </div>
                            <!-- AREA 3 -->
                            <div class="col-12 mt-2"> 
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <select class="form-control" id="AREA3_PPT" name="AREA3_PPT">
                                                <option selected disabled>Seleccione una opción</option>
                                                <option value="1">N/A</option>
                                                <option value="2">Agronomía</option>
                                                <option value="3">C. Educación</option>
                                                <option value="4">C. Naturales</option>
                                                <option value="5">C. Salud</option>
                                                <option value="6">C. Sociales</option>
                                                <option value="7">Administración </option>
                                                <option value="8">Ingeniería</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Lo cumple</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="AREA3_CUMPLE_PPT" id="AREA3_CUMPLE_SI" value="si">
                                            <label class="form-check-label" for="AREA3_CUMPLE_SI">Si</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="AREA3_CUMPLE_PPT" id="AREA3_CUMPLE_NO" value="no">
                                                <label class="form-check-label" for="AREA3_CUMPLE_NO">No</label>
                                            </div>
                                    </div>
                                </div> 
                            </div>
                            <!-- AREA 4 -->
                            <div class="col-12 mt-2"> 
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <select class="form-control" id="AREA4_PPT" name="AREA4_PPT">
                                                <option selected disabled>Seleccione una opción</option>
                                                <option value="1">N/A</option>
                                                <option value="2">Agronomía</option>
                                                <option value="3">C. Educación</option>
                                                <option value="4">C. Naturales</option>
                                                <option value="5">C. Salud</option>
                                                <option value="6">C. Sociales</option>
                                                <option value="7">Administración </option>
                                                <option value="8">Ingeniería</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Lo cumple</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="AREA4_CUMPLE_PPT" id="AREA4_CUMPLE_SI" value="si">
                                            <label class="form-check-label" for="AREA4_CUMPLE_SI">Si</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="AREA4_CUMPLE_PPT" id="AREA4_CUMPLE_NO" value="no">
                                                <label class="form-check-label" for="AREA4_CUMPLE_NO">No</label>
                                            </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Área de conocimiento específica requerida</label>
                                <textarea class="form-control" id="AREA_REQUERIDA_PPT" name="AREA_REQUERIDA_PPT" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Área de conocimiento del trabajador</label>
                                <input type="text" class="form-control" id="AREA_CONOCIMIENTOTRABAJADOR_PPT" name="AREA_CONOCIMIENTOTRABAJADOR_PPT">
                            </div>
                        </div>    
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 ">
                            <h5>Estudios de posgrado requeridos</h5>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-1 mt-4">
                            <label>Especialidad</label>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Egresado</label>
                                <select class="form-control" id="EGRESADO_ESPECIALIDAD_PPT" name="EGRESADO_ESPECIALIDAD_PPT">
                                    <option selected disabled>Seleccione una opción</option>
                                    <option value="1">Egresado</option>
                                    <option value="2">No Egresado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Graduado</label>
                                <select class="form-control" id="GRADUADO_ESPECIALIDA_PPT" name="GRADUADO_ESPECIALIDA_PPT">
                                    <option selected disabled>Seleccione una opción</option>
                                    <option value="1">Deseable</option>
                                    <option value="2">No Deseable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-1">
                            <label>Lo cumple</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ESPECIALIDAD_CUMPLE_PPT" id="ESPECIALIDAD_CUMPLE_SI" value="si">
                                <label class="form-check-label" for="ESPECIALIDAD_CUMPLE_SI">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ESPECIALIDAD_CUMPLE_PPT" id="ESPECIALIDAD_CUMPLE_NO" value="no">
                                <label class="form-check-label" for="ESPECIALIDAD_CUMPLE_NO">No</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Área de conocimiento requerida</label>
                                <input type="text" class="form-control" id="AREAREQUERIDA_CONOCIMIENTO_PPT" name="AREAREQUERIDA_CONOCIMIENTO_PPT">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 mt-4">
                            <label>Maestría</label>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Egresado</label>
                                <select class="form-control" id="EGRESADO_MAESTRIA_PPT" name="EGRESADO_MAESTRIA_PPT">
                                    <option selected disabled>Seleccione una opción</option>
                                    <option value="1">Egresado</option>
                                    <option value="2">No Egresado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Graduado</label>
                                <select class="form-control" id="GRADUADO_MAESTRIA_PPT" name="GRADUADO_MAESTRIA_PPT">
                                    <option selected disabled>Seleccione una opción</option>
                                    <option value="1">Deseable</option>
                                    <option value="2">No Deseable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <label>Lo cumple</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="MAESTRIA_CUMPLE_PPT" id="MAESTRIA_CUMPLE_SI" value="si">
                                <label class="form-check-label" for="MAESTRIA_CUMPLE_SI">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="MAESTRIA_CUMPLE_PPT" id="MAESTRIA_CUMPLE_NO" value="no">
                                <label class="form-check-label" for="MAESTRIA_CUMPLE_NO">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-1 mt-4">
                            <label>Doctorado</label>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Egresado</label>
                                <select class="form-control" id="EGRESADO_DOCTORADO_PPT" name="EGRESADO_DOCTORADO_PPT">
                                    <option selected disabled>Seleccione una opción</option>
                                    <option value="1">Egresado</option>
                                    <option value="2">No Egresado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Graduado</label>
                                <select class="form-control" id="GRADUADO_DOCTORADO_PPT" name="GRADUADO_DOCTORADO_PPT">
                                    <option selected disabled>Seleccione una opción</option>
                                    <option value="1">Deseable</option>
                                    <option value="2">No Deseable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-1">
                            <label>Lo cumple</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="DOCTORADO_CUMPLE_PPT" id="DOCTORADO_CUMPLE_SI" value="si">
                                <label class="form-check-label" for="DOCTORADO_CUMPLE_SI">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="DOCTORADO_CUMPLE_PPT" id="DOCTORADO_CUMPLE_NO" value="no">
                                <label class="form-check-label" for="DOCTORADO_CUMPLE_NO">No</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Área de conocimiento del trabajador</label>
                                <input type="text" class="form-control" id="AREA_CONOCIMINETO_TRABAJADOR_PPT" name="AREA_CONOCIMINETO_TRABAJADOR_PPT">
                            </div>
                        </div>
                    </div>

                      <!-- III. Conocimientos adicionales -->
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h4>III. Conocimientos adicionaless</h4>
                </div>
            </div>
                    














               




          

            



            
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>


  
  @endsection