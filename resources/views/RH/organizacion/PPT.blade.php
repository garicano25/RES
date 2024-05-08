@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 10px; border-radius: 10px;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-filetype-ppt"></i> PPT</h3>


    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_ppt" data-bs-toggle="modal" data-bs-target="#miModal_PPT" style="margin-left: auto;">
    Nuevo PPT  <i class="bi bi-plus-circle"></i> 
    </button>
 </ol>
  

   </div>

   


<!-- MODAL  -->
<div class="modal modal-fullscreen fade" id="miModal_PPT" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel" >Perfil del puesto de trabajo(PPT)</h5>
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
                        <input type="text" class="form-control" id="AREA_TRABAJADOR_PPT" name="AREA_TRABAJADOR_PPT">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label>Propósito o finalidad del puesto</label>
                        <textarea class="form-control" id="PROPOSITO_FINALIDAD_PPT" name="PROPOSITO_FINALIDAD_PPT" rows="3"></textarea>
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
                <div class="col-4">
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
                <div class="col-2">
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="EDAD_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="EDAD_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-4">
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
                <div class="col-2">
                   <br>
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
                <div class="col-4">
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
                <div class="col-2">
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="ESTADO_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="ESTADO_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-4">
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
                <div class="col-2">
                    <br>
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
                <div class="col-4">
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
                <div class="col-2">
                    <br>
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
                                     <br>
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
                                    <br>
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
                                     <br>
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
                                    <br>
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
                                    <br>
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
                                     <br>
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
                                    <div class="col-8 ">
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
                                        <br>
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
                            <div class="col-12"> 
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label></label>
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
                                        <br>
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
                            <div class="col-12"> 
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label></label>
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
                                        <br>
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
                            <div class="col-12"> 
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label></label>
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
                                        <br>
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
                            <h6>Estudios de posgrado requeridos</h6>
                        </div>
                    </div>
                    
                    <div class="row mb-1">
                        <div class="col-1 mt-4">
                            <label>Especialidad</label>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label>Egresado</label>
                                <input type="text" class="form-control" id="EGRESADO_ESPECIALIDAD_PPT" name="EGRESADO_ESPECIALIDAD_PPT">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label>Graduado</label>
                                <input type="text" class="form-control" id="GRADUADO_ESPECIALIDA_PPT" name="GRADUADO_ESPECIALIDA_PPT">
                            </div>
                        </div>
                        <div class="col-2">
                           <br>
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
                        <div class="col-1">
                            <div class="form-group">
                                <label>Egresado</label>
                                <input type="text" class="form-control" id="EGRESADO_MAESTRIA_PPT" name="EGRESADO_MAESTRIA_PPT">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label>Graduado</label>
                                <input type="text" class="form-control" id="GRADUADO_MAESTRIA_PPT" name="GRADUADO_MAESTRIA_PPT">
                            </div>
                        </div>
                        <div class="col-2">
                           <br>
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
                        <div class="col-1">
                            <div class="form-group">
                                <label>Egresado</label>
                                <input type="text" class="form-control" id="EGRESADO_DOCTORADO_PPT" name="EGRESADO_DOCTORADO_PPT">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label>Graduado</label>
                                <input type="text" class="form-control" id="GRADUADO_DOCTORADO_PPT" name="GRADUADO_DOCTORADO_PPT">
                            </div>
                        </div>
                        <div class="col-2">
                            <br>
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
                    <h4>III. Conocimientos adicionales</h4>
                </div>
            </div>
                    
            <div class="row mb-3">
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th rowspan="2">Ofimática</th>
                                <th colspan="5" class="text-center">Nivel de dominio </th>
                            </tr>
                            <tr>
                                <th>Aplica</th>
                                <th>Bajo</th>
                                <th>Medio</th>
                                <th>Alto</th>
                                <th>Si</th>
                                <th>No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Word</td>
                               
                                <td>
                                    <input type="text" class="form-control" id="WORD_APLICA_PPT" name="WORD_APLICA_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="WORD_BAJO_PPT" name="WORD_BAJO_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="WORD_MEDIO_PPT" name="WORD_MEDIO_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="WORD_ALTO_PPT" name="WORD_ALTO_PPT">
                                </td>
                                <td>
                                    <label class="form-check-label" for="WORD_CUMPLE_SI">Si</label>
                                    <input class="form-check-input" type="radio" name="WORD_CUMPLE_PPT" id="WORD_CUMPLE_SI" value="Si">
                                </td>
                                <td>
                                    <label class="form-check-label" for="WORD_CUMPLE_NO">No</label>
                                    <input class="form-check-input" type="radio" name="WORD_CUMPLE_PPT" id="WORD_CUMPLE_NO" value="no">
                                </td>
                            </tr>
                            <tr>
                                <td>Excel</td>
                                <td>
                                    <input type="text" class="form-control" id="EXCEL_APLICA_PPT" name="EXCEL_APLICA_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="EXCEL_BAJO_PPT" name="EXCEL_BAJO_PPT">
                                </td>
                                
                                <td>
                                    <input type="text" class="form-control" id="EXCEL_MEDIO_PPT" name="EXCEL_MEDIO_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="EXCEL_ALTO_PPT" name="EXCEL_ALTO_PPT">
                                </td>
                                <td>
                                    <label class="form-check-label" for="EXCEL_CUMPLE_SI">Si</label>
                                    <input class="form-check-input" type="radio" name="EXCEL_CUMPLE_PPT" id="EXCEL_CUMPLE_SI" value="Si">
                                </td>
                                <td>
                                    <label class="form-check-label" for="EXCEL_CUMPLE_NO">No</label>
                                    <input class="form-check-input" type="radio" name="EXCEL_CUMPLE_PPT" id="EXCEL_CUMPLE_NO" value="no">
                                </td>
                            </tr>
                            <tr>
                                <td>Power Point</td>
                                <td>
                                    <input type="text" class="form-control" id="POWER_APLICA_PPT" name="POWER_APLICA_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="POWER_BAJO_PPT" name="POWER_BAJO_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="POWER_MEDIO_PPT" name="POWER_MEDIO_PPT">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="POWER_ALTO_PPT" name="POWER_ALTO_PPT">
                                </td>
                                <td>
                                    <label class="form-check-label" for="POWER_CUMPLE_SI">Si</label>
                                    <input class="form-check-input" type="radio" name="POWER_CUMPLE_PPT" id="POWER_CUMPLE_SI" value="Si">
                                </td>
                                <td>
                                    <label class="form-check-label" for="POWER _CUMPLE_NO">No</label>
                                    <input class="form-check-input" type="radio" name="POWER_CUMPLE_PPT" id="POWER _CUMPLE_NO" value="no">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th rowspan="2">Idioma</th>
                                <th colspan="5" class="text-center">Nivel de dominio en %</th>
                            </tr>
                            <tr>
                                <th>Aplica</th>
                                <th>Hablar</th>
                                <th>Escribir</th>
                                <th>Leer</th>
                                <th>Escuchar</th>
                                <th>Si</th>
                                <th>No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" id="NOMBRE_IDOMA1_PPT" name="NOMBRE_IDOMA1_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="APLICA_IDIOMA1_PPT" name="APLICA_IDIOMA1_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="HABLAR_IDIOMA1_PPT" name="HABLAR_IDIOMA1_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="ESCRIBIR_IDIOMA1_PPT" name="ESCRIBIR_IDIOMA1_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="LEER_IDIOMA1_PPT" name="LEER_IDIOMA1_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="ESCUCHAR_IDIOMA1_PPT" name="ESCUCHAR_IDIOMA1_PPT">
                                </td>
                                <td>
                                    <label class="form-check-label" for="IDIOMA1_CUMPLE_SI">Si</label>
                                    <input class="form-check-input" type="radio" name="IDIOMA1_CUMPLE_PPT" id="IDIOMA1_CUMPLE_SI" value="Si">
                                </td>
                                <td>
                                    <label class="form-check-label" for="IDIOMA1_CUMPLE_NO">No</label>
                                    <input class="form-check-input" type="radio" name="IDIOMA1_CUMPLE_PPT" id="IDIOMA1_CUMPLE_NO" value="no">
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" id="NOMBRE_IDIOMA2_PPT" name="NOMBRE_IDIOMA2_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="APLICA_IDIOMA2_PPT" name="APLICA_IDIOMA2_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="HABLAR_IDIOMA2_PPT" name="HABLAR_IDIOMA2_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="ESCRIBIR_IDIOMA2_PPT" name="ESCRIBIR_IDIOMA2_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="LEER_IDIOMA2_PPT" name="LEER_IDIOMA2_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="ESCUCHAR_IDIOMA2_PPT" name="ESCUCHAR_IDIOMA2_PPT">
                                </td>
                                <td>
                                    <label class="form-check-label" for="IDIOMA2_CUMPLE_SI">Si</label>
                                    <input class="form-check-input" type="radio" name="IDIOMA2_CUMPLE_PPT" id="IDIOMA2_CUMPLE_SI" value="Si">
                                </td>
                                <td>
                                    <label class="form-check-label" for="IDIOMA2_CUMPLE_NO">No</label>
                                    <input class="form-check-input" type="radio" name="IDIOMA2_CUMPLE_PPT" id="IDIOMA2_CUMPLE_NO" value="no">
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" id="NOMBRE_IDIOMA3_PPT" name="NOMBRE_IDIOMA3_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="APLICA_IDIOMA3_PPT" name="APLICA_IDIOMA3_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="HABLAR_IDIOMA3_PPT" name="HABLAR_IDIOMA3_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="ESCRIBIR_IDIOMA3_PPT" name="ESCRIBIR_IDIOMA3_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="LEER_IDIOMA3_PPT" name="LEER_IDIOMA3_PPT">
                                </td>
                                <td><input type="number" class="form-control" id="ESCUCHAR_IDIOMA3_PPT" name="ESCUCHAR_IDIOMA3_PPT">
                                </td>
                                <td>
                                    <label class="form-check-label" for="IDIOMA3_CUMPLE_SI">Si</label>
                                    <input class="form-check-input" type="radio" name="IDIOMA3_CUMPLE_PPT" id="IDIOMA3_CUMPLE_SI" value="Si">
                                </td>
                                <td>
                                    <label class="form-check-label" for="IDIOMA3_CUMPLE_NO">No</label>
                                    <input class="form-check-input" type="radio" name="IDIOMA3_CUMPLE_PPT" id="IDIOMA3_CUMPLE_NO" value="no">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                  <div class="accordion" id="otrosConocimientosAccordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="cursoTemasHeading">
                        <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemasCollapse" aria-expanded="false" aria-controls="cursoTemasCollapse">
                          Otros conocimientos adicionales
                        </button>
                      </h2>
                      <div id="cursoTemasCollapse" class="accordion-collapse collapse" aria-labelledby="cursoTemasHeading" data-bs-parent="#otrosConocimientosAccordion">
                        <div class="accordion-body">
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                    <th class="text-center">Cursos/Temas</th>
                                    <th class="text-center">*R</th>
                                    <th class="text-center">*D</th>
                                    <th class="text-center">Si</th>
                                    <th class="text-center">No</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <input type="text" class="form-control" id="CURSO1_PPT" name="CURSO1_PPT">
                                </td>
                                  <td>
                                    <input type="text" class="form-control" id="CURSO1_REQUERIDO_PPT" name="CURSO1_REQUERIDO_PPT">
                                </td>
                                  <td>
                                    <input type="text" class="form-control" id="CURSO1_DESEABLE_PPT" name="CURSO1_DESEABLE_PPT">
                                </td>
                                  <td>
                                    <input class="form-check-input" type="radio" name="CURSO1_CUMPLE_PPT" id="CURSO1_CUMPLE_SI" value="Si">
                                 </td>
                                 <td>
                                    <input class="form-check-input" type="radio" name="CURSO1_CUMPLE_PPT" id="CURSO1_CUMPLE_NO" value="no">
                                 </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO2_PPT" name="CURSO2_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO2_REQUERIDO_PPT" name="CURSO2_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO2_DESEABLE_PPT" name="CURSO2_DESEABLE_PPT">
                                    </td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO2_CUMPLE_PPT" id="CURSO2_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO2_CUMPLE_PPT" id="CURSO2_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO3_PPT" name="CURSO3_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO3_REQUERIDO_PPT" name="CURSO3_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO3_DESEABLE_PPT" name="CURSO3_DESEABLE_PPT">
                                    </td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO3_CUMPLE_PPT" id="CURSO3_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO3_CUMPLE_PPT" id="CURSO3_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO4_PPT" name="CURSO4_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO4_REQUERIDO_PPT" name="CURSO4_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO4_DESEABLE_PPT" name="CURSO4_DESEABLE_PPT">
                                    </td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO4_CUMPLE_PPT" id="CURSO4_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO4_CUMPLE_PPT" id="CURSO4_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO5_PPT" name="CURSO5_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO5_REQUERIDO_PPT" name="CURSO5_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO5_DESEABLE_PPT" name="CURSO5_DESEABLE_PPT">
                                    </td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO5_CUMPLE_PPT" id="CURSO5_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO5_CUMPLE_PPT" id="CURSO5_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO6_PPT" name="CURSO6_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO6_REQUERIDO_PPT" name="CURSO6_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO6_DESEABLE_PPT" name="CURSO6_DESEABLE_PPT">
                                    </td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO6_CUMPLE_PPT" id="CURSO6_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO6_CUMPLE_PPT" id="CURSO6_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO7_PPT" name="CURSO7_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO7_REQUERIDO_PPT" name="CURSO7_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO7_DESEABLE_PPT" name="CURSO7_DESEABLE_PPT">
                                    </td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO7_CUMPLE_PPT" id="CURSO7_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO7_CUMPLE_PPT" id="CURSO7_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO8_PPT" name="CURSO8_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO8_REQUERIDO_PPT" name="CURSO8_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO8_DESEABLE_PPT" name="CURSO8_DESEABLE_PPT">
                                    </td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO8_CUMPLE_PPT" id="CURSO8_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO8_CUMPLE_PPT" id="CURSO8_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO9_PPT" name="CURSO9_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO9_REQUERIDO_PPT" name="CURSO9_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO9_DESEABLE_PPT" name="CURSO9_DESEABLE_PPT">
                                    </td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO9_CUMPLE_PPT" id="CURSO9_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO9_CUMPLE_PPT" id="CURSO9_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td
                                    ><input type="text" class="form-control" id="CURSO10_PPT" name="CURSO10_PPT">
                                </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO10_REQUERIDO_PPT" name="CURSO10_REQUERIDO_PPT">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="CURSO10_DESEABLE_PPT" name="CURSO10_DESEABLE_PPT">
                                    </td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO10_CUMPLE_PPT" id="CURSO10_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO10_CUMPLE_PPT" id="CURSO10_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <p class="mt-3 text-center">
                            <strong>*R: Requerido     *D: Deseable</strong> 
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                    <div class="accordion" id="otrosConocimientos1Accordion">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="cursoTemas1Heading">
                          <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemas1Collapse" aria-expanded="false" aria-controls="cursoTemas1Collapse">
                            Otros conocimientos adicionales
                          </button>
                        </h2>
                        <div id="cursoTemas1Collapse" class="accordion-collapse collapse" aria-labelledby="cursoTemas1Heading" data-bs-parent="#otrosConocimientos1Accordion">
                          <div class="accordion-body">
                            <div class="table-responsive">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th class="text-center">Cursos/Temas</th>
                                    <th class="text-center">*R</th>
                                    <th class="text-center">*D</th>
                                    <th class="text-center">Si</th>
                                    <th class="text-center">No</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><input type="text" class="form-control" id="CURSO11_PPT" name="CURSO11_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO11_REQUERIDO_PPT" name="CURSO11_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO11_DESEABLE_PPT" name="CURSO11_DESEABLE_PPT"></td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO11_CUMPLE_PPT" id="CURSO11_CUMPLE_SI" value="Si">
                                   </td>
                                   <td>
                                      <input class="form-check-input" type="radio" name="CURSO11_CUMPLE_PPT" id="CURSO11_CUMPLE_NO" value="no">
                                   </td>
                                  </tr>
  
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO12_PPT" name="CURSO12_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO12_REQUERIDO_PPT" name="CURSO12_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO12_DESEABLE_PPT" name="CURSO12_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO12_CUMPLE_PPT" id="CURSO12_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO12_CUMPLE_PPT" id="CURSO12_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO13_PPT" name="CURSO13_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO13_REQUERIDO_PPT" name="CURSO13_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO13_DESEABLE_PPT" name="CURSO13_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO13_CUMPLE_PPT" id="CURSO13_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO13_CUMPLE_PPT" id="CURSO13_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO14_PPT" name="CURSO14_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO14_REQUERIDO_PPT" name="CURSO14_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO14_DESEABLE_PPT" name="CURSO14_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO14_CUMPLE_PPT" id="CURSO14_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO14_CUMPLE_PPT" id="CURSO14_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO15_PPT" name="CURSO15_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO15_REQUERIDO_PPT" name="CURSO15_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO15_DESEABLE_PPT" name="CURSO15_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO15_CUMPLE_PPT" id="CURSO15_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO15_CUMPLE_PPT" id="CURSO15_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO16_PPT" name="CURSO16_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO16_REQUERIDO_PPT" name="CURSO16_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO16_DESEABLE_PPT" name="CURSO16_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO16_CUMPLE_PPT" id="CURSO16_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO16_CUMPLE_PPT" id="CURSO16_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO17_PPT" name="CURSO17_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO17_REQUERIDO_PPT" name="CURSO17_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO17_DESEABLE_PPT" name="CURSO17_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO17_CUMPLE_PPT" id="CURSO17_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO17_CUMPLE_PPT" id="CURSO17_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO18_PPT" name="CURSO18_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO18_REQUERIDO_PPT" name="CURSO18_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO18_DESEABLE_PPT" name="CURSO18_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO18_CUMPLE_PPT" id="CURSO18_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO18_CUMPLE_PPT" id="CURSO18_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO19_PPT" name="CURSO19_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO19_REQUERIDO_PPT" name="CURSO19_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO19_DESEABLE_PPT" name="CURSO19_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO19_CUMPLE_PPT" id="CURSO19_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO19_CUMPLE_PPT" id="CURSO19_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO20_PPT" name="CURSO20_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO20_REQUERIDO_PPT" name="CURSO20_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO20_DESEABLE_PPT" name="CURSO20_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO20_CUMPLE_PPT" id="CURSO20_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO20_CUMPLE_PPT" id="CURSO20_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <p class="mt-3 text-center">
                              <strong>*R: Requerido     *D: Deseable</strong> 
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row mb-3">
                <div class="col-6">
                  <div class="accordion" id="otrosConocimientos2Accordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="cursoTemas2Heading">
                        <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemas2Collapse" aria-expanded="false" aria-controls="cursoTemas2Collapse">
                          Otros conocimientos adicionales
                        </button>
                      </h2>
                      <div id="cursoTemas2Collapse" class="accordion-collapse collapse" aria-labelledby="cursoTemas2Heading" data-bs-parent="#otrosConocimientos2Accordion">
                        <div class="accordion-body">
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                    <th class="text-center">Cursos/Temas</th>
                                    <th class="text-center">*R</th>
                                    <th class="text-center">*D</th>
                                    <th class="text-center">Si</th>
                                    <th class="text-center">No</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><input type="text" class="form-control" id="CURSO21_PPT" name="CURSO21_PPT"></td>
                                  <td><input type="text" class="form-control" id="CURSO21_REQUERIDO_PPT" name="CURSO21_REQUERIDO_PPT"></td>
                                  <td><input type="text" class="form-control" id="CURSO21_DESEABLE_PPT" name="CURSO21_DESEABLE_PPT"></td>
                                  <td>
                                    <input class="form-check-input" type="radio" name="CURSO21_CUMPLE_PPT" id="CURSO21_CUMPLE_SI" value="Si">
                                 </td>
                                 <td>
                                    <input class="form-check-input" type="radio" name="CURSO21_CUMPLE_PPT" id="CURSO21_CUMPLE_NO" value="no">
                                 </td>
                                </tr>

                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO22_PPT" name="CURSO22_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO22_REQUERIDO_PPT" name="CURSO22_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO22_DESEABLE_PPT" name="CURSO22_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO22_CUMPLE_PPT" id="CURSO22_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO22_CUMPLE_PPT" id="CURSO22_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO23_PPT" name="CURSO23_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO23_REQUERIDO_PPT" name="CURSO23_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO23_DESEABLE_PPT" name="CURSO23_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO23_CUMPLE_PPT" id="CURSO23_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO23_CUMPLE_PPT" id="CURSO23_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO24_PPT" name="CURSO24_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO24_REQUERIDO_PPT" name="CURSO24_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO24_DESEABLE_PPT" name="CURSO24_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO24_CUMPLE_PPT" id="CURSO24_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO24_CUMPLE_PPT" id="CURSO24_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO25_PPT" name="CURSO25_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO25_REQUERIDO_PPT" name="CURSO25_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO25_DESEABLE_PPT" name="CURSO25_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO25_CUMPLE_PPT" id="CURSO25_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO25_CUMPLE_PPT" id="CURSO25_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO26_PPT" name="CURSO26_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO26_REQUERIDO_PPT" name="CURSO26_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO26_DESEABLE_PPT" name="CURSO26_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO26_CUMPLE_PPT" id="CURSO26_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO26_CUMPLE_PPT" id="CURSO26_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO27_PPT" name="CURSO27_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO27_REQUERIDO_PPT" name="CURSO27_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO27_DESEABLE_PPT" name="CURSO27_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO27_CUMPLE_PPT" id="CURSO27_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO27_CUMPLE_PPT" id="CURSO27_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO28_PPT" name="CURSO28_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO28_REQUERIDO_PPT" name="CURSO28_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO28_DESEABLE_PPT" name="CURSO28_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO28_CUMPLE_PPT" id="CURSO28_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO28_CUMPLE_PPT" id="CURSO28_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO29_PPT" name="CURSO29_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO29_REQUERIDO_PPT" name="CURSO29_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO29_DESEABLE_PPT" name="CURSO29_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO29_CUMPLE_PPT" id="CURSO29_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO29_CUMPLE_PPT" id="CURSO29_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="CURSO30_PPT" name="CURSO30_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO30_REQUERIDO_PPT" name="CURSO30_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO30_DESEABLE_PPT" name="CURSO30_DESEABLE_PPT"></td>
  
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO30_CUMPLE_PPT" id="CURSO30_CUMPLE_SI" value="Si">
                                  </td>
                                  <td>
                                      <input class="form-check-input" type="radio" name="CURSO30_CUMPLE_PPT" id="CURSO30_CUMPLE_NO" value="no">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <p class="mt-3 text-center">
                            <strong>*R: Requerido     *D: Deseable</strong> 
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                    <div class="accordion" id="otrosConocimientos3Accordion">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="cursoTemas3Heading">
                          <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemas3Collapse" aria-expanded="false" aria-controls="cursoTemas3Collapse">
                            Otros conocimientos adicionales
                          </button>
                        </h2>
                        <div id="cursoTemas3Collapse" class="accordion-collapse collapse" aria-labelledby="cursoTemas3Heading" data-bs-parent="#otrosConocimientos3Accordion">
                          <div class="accordion-body">
                            <div class="table-responsive">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th class="text-center">Cursos/Temas</th>
                                    <th class="text-center">*R</th>
                                    <th class="text-center">*D</th>
                                    <th class="text-center">Si</th>
                                    <th class="text-center">No</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><input type="text" class="form-control" id="CURSO31_PPT" name="CURSO31_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO31_REQUERIDO_PPT" name="CURSO31_REQUERIDO_PPT"></td>
                                    <td><input type="text" class="form-control" id="CURSO31_DESEABLE_PPT" name="CURSO31_DESEABLE_PPT"></td>
                                    <td>
                                      <input class="form-check-input" type="radio" name="CURSO31_CUMPLE_PPT" id="CURSO31_CUMPLE_SI" value="Si">
                                   </td>
                                   <td>
                                      <input class="form-check-input" type="radio" name="CURSO31_CUMPLE_PPT" id="CURSO31_CUMPLE_NO" value="no">
                                   </td>
                                  </tr>
  
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO32_PPT" name="CURSO32_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO32_REQUERIDO_PPT" name="CURSO32_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO32_DESEABLE_PPT" name="CURSO32_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO32_CUMPLE_PPT" id="CURSO32_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO32_CUMPLE_PPT" id="CURSO32_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO33_PPT" name="CURSO33_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO33_REQUERIDO_PPT" name="CURSO33_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO33_DESEABLE_PPT" name="CURSO33_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO33_CUMPLE_PPT" id="CURSO33_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO33_CUMPLE_PPT" id="CURSO33_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO34_PPT" name="CURSO34_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO3_REQUERIDO_PPT" name="CURSO34_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO14_DESEABLE_PPT" name="CURSO34_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO34_CUMPLE_PPT" id="CURSO34_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO34_CUMPLE_PPT" id="CURSO34_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO35_PPT" name="CURSO35_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO35_REQUERIDO_PPT" name="CURSO35_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO35_DESEABLE_PPT" name="CURSO35_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO35_CUMPLE_PPT" id="CURSO35_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO35_CUMPLE_PPT" id="CURSO35_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO36_PPT" name="CURSO36_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO36_REQUERIDO_PPT" name="CURSO36_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO36_DESEABLE_PPT" name="CURSO36_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO36_CUMPLE_PPT" id="CURSO36_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO36_CUMPLE_PPT" id="CURSO36_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO37_PPT" name="CURSO37_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO37_REQUERIDO_PPT" name="CURSO37_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO37_DESEABLE_PPT" name="CURSO37_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO37_CUMPLE_PPT" id="CURSO37_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO37_CUMPLE_PPT" id="CURSO37_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO38_PPT" name="CURSO38_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO38_REQUERIDO_PPT" name="CURSO38_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO38_DESEABLE_PPT" name="CURSO38_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO38_CUMPLE_PPT" id="CURSO38_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO38_CUMPLE_PPT" id="CURSO38_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO39_PPT" name="CURSO39_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO39_REQUERIDO_PPT" name="CURSO39_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO39_DESEABLE_PPT" name="CURSO39_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO39_CUMPLE_PPT" id="CURSO39_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO39_CUMPLE_PPT" id="CURSO39_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                  <tr>
                                      <td><input type="text" class="form-control" id="CURSO40_PPT" name="CURSO40_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO40_REQUERIDO_PPT" name="CURSO40_REQUERIDO_PPT"></td>
                                      <td><input type="text" class="form-control" id="CURSO40_DESEABLE_PPT" name="CURSO40_DESEABLE_PPT"></td>
    
                                      <td>
                                        <input class="form-check-input" type="radio" name="CURSO40_CUMPLE_PPT" id="CURSO40_CUMPLE_SI" value="Si">
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="CURSO40_CUMPLE_PPT" id="CURSO40_CUMPLE_NO" value="no">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <p class="mt-3 text-center">
                              <strong>*R: Requerido     *D: Deseable</strong> 
                            </p>
                          </div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- IV. Experiencia -->
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h4>IV. Experiencia</h4>
                </div>
            </div>
                    
            <div class="row mb-3">
                <div class="col-5">
                    <label>Experiencia laboral general requerida</label>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <input type="text" class="form-control" id="EXPERIENCIA_LABORAL_GENERAL_PPT" name="EXPERIENCIA_LABORAL_GENERAL_PPT">
                    </div>
                 </div>   
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EXPERIENCIAGENERAL_CUMPLE_PPT" id="EXPERIENCIAGENERAL_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="EXPERIENCIAGENERAL_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EXPERIENCIAGENERAL_CUMPLE_PPT" id="EXPERIENCIAGENERAL_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="EXPERIENCIAGENERAL_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>
            <div class="row mb-3">
                <div class="col-5">
                    <label>Indique la cantidad total de años de experiencia laboral</label>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <input type="text" class="form-control" id="CANTIDAD_EXPERIENCIA_PPT" name="CANTIDAD_EXPERIENCIA_PPT">
                    </div>
                 </div>   
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="CANTIDAD_EXPERIENCIA_CUMPLE_PPT" id="CANTIDAD_EXPERIENCIA_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="CANTIDAD_EXPERIENCIA_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="CANTIDAD_EXPERIENCIA_CUMPLE_PPT" id="CANTIDAD_EXPERIENCIA_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="CANTIDAD_EXPERIENCIA_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>
            <div class="row mb-3">
                <div class="col-5">
                    <label>Experiencia laboral específica requerida</label>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <input type="text" class="form-control" id="EXPERIENCIA_ESPECIFICA_PPT" name="EXPERIENCIA_ESPECIFICA_PPT">
                    </div>
                 </div>   
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EXPERIENCIA_ESPECIFICA_CUMPLE_PPT" id="EXPERIENCIA_ESPECIFICA_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="EXPERIENCIA_ESPECIFICA_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EXPERIENCIA_ESPECIFICA_CUMPLE_PPT" id="EXPERIENCIA_ESPECIFICA_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="EXPERIENCIA_ESPECIFICA_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>
            <div class="row mb-3">
                <div class="col-12 ">
                    <h6>Marque el nivel mínimo de puesto que se requiere como experiencia</h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3 mt-1">
                    <label>Practicante profesional</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="PRACTICA_PROFESIONAL_PPT" name="PRACTICA_PROFESIONAL_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="PRACTICA_PROFESIONAL_CUMPLE_PPT" id="PRACTICA_PROFESIONAL_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="PRACTICA_PROFESIONAL_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="PRACTICA_PROFESIONAL_CUMPLE_PPT" id="PRACTICA_PROFESIONAL_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="PRACTICA_PROFESIONAL_CUMPLE_NO">No</label>
                    </div>
                </div>

                <div class="col-3 mt-1">
                    <label>Elaboración de reportes</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="ELABORACION_REPORTES_PPT" name="ELABORACION_REPORTES_PPT">
                    </div>
                </div>
               
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ELABORACION_REPORTES_CUMPLE_PPT" id="ELABORACION_REPORTES_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="ELABORACION_REPORTES_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ELABORACION_REPORTES_CUMPLE_PPT" id="ELABORACION_REPORTES_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="ELABORACION_REPORTES_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>
            <div class="row mb-3">
                <div class="col-3 mt-1">
                    <label>Auxiliar o Asistente</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="AUXILIAR_ASISTENTE_PPT" name="AUXILIAR_ASISTENTE_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="AUXILIAR_ASISTENTE_CUMPLE_PPT" id="AUXILIAR_ASISTENTE_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="AUXILIAR_ASISTENTE_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="AUXILIAR_ASISTENTE_CUMPLE_PPT" id="AUXILIAR_ASISTENTE_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="AUXILIAR_ASISTENTE_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-3 mt-1">
                    <label>Supervisor o coordinador</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="SUPERVISOR_COORDINADOR_PPT" name="SUPERVISOR_COORDINADOR_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="SUPERVISOR_COORDINADOR_CUMPLE_PPT" id="SUPERVISOR_COORDINADOR_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="SUPERVISOR_COORDINADOR_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="SUPERVISOR_COORDINADOR_CUMPLE_PPT" id="SUPERVISOR_COORDINADOR_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="SUPERVISOR_COORDINADOR_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>
            <div class="row mb-3">
                <div class="col-3 mt-1">
                    <label>Analista o Especialista</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="ANALISTA_ESPECIALISTA_PPT" name="ANALISTA_ESPECIALISTA_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ANALISTA_ESPECIALISTA_CUMPLE_PPT" id="ANALISTA_ESPECIALISTA_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="ANALISTA_ESPECIALISTA_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ANALISTA_ESPECIALISTA_CUMPLE_PPT" id="ANALISTA_ESPECIALISTA_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="ANALISTA_ESPECIALISTA_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-3 mt-1">
                    <label>Consultor o asesor</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="CONSULTOR_ASESOR_PPT" name="CONSULTOR_ASESOR_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="CONSULTOR_ASESOR_CUMPLE_PPT" id="CONSULTOR_ASESOR_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="CONSULTOR_ASESOR_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="CONSULTOR_ASESOR_CUMPLE_PPT" id="CONSULTOR_ASESOR_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="CONSULTOR_ASESOR_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>

            <div class="row mb-3">
                <div class="col-3 mt-1">
                    <label>Técnico de muestreo</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="TECNICO_MUESTREO_PPT" name="TECNICO_MUESTREO_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="TECNICO_MUESTREO_CUMPLE_PPT" id="TECNICO_MUESTREO_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="TECNICO_MUESTREO_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="TECNICO_MUESTREO_CUMPLE_PPT" id="TECNICO_MUESTREO_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="TECNICO_MUESTREO_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-3 mt-1">
                    <label>Jefe de área o departamento</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="JEFE_AREA_PPT" name="JEFE_AREA_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="JEFE_AREA_CUMPLE_PPT" id="JEFE_AREA_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="JEFE_AREA_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="JEFE_AREA_CUMPLE_PPT" id="JEFE_AREA_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="JEFE_AREA_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>

            <div class="row mb-3">
                <div class="col-3 mt-1">
                    <label>Signatario</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="SIGNATARIO_PPT" name="SIGNATARIO_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="SIGNATARIO_CUMPLE_PPT" id="SIGNATARIO_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="SIGNATARIO_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="SIGNATARIO_CUMPLE_PPT" id="SIGNATARIO_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="SIGNATARIO_CUMPLE_NO">No</label>
                    </div>
                </div>
                <div class="col-3 mt-1">
                    <label>Gerente o Director</label>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="GERENTE_DIRECTOR_PPT" name="GERENTE_DIRECTOR_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="GERENTE_DIRECTOR_CUMPLE_PPT" id="GERENTE_DIRECTOR_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="GERENTE_DIRECTOR_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="GERENTE_DIRECTOR_CUMPLE_PPT" id="GERENTE_DIRECTOR_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="GERENTE_DIRECTOR_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>
            <div class="row mb-3">
                <div class="col-12 ">
                    <h6>Indique el tiempo de experiencia específica requerida para el cargo</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-10">
                    <div class="form-group">
                        <input type="text" class="form-control" id="TIEMPO_EXPERIENCIA_PPT" name="TIEMPO_EXPERIENCIA_PPT">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="TIEMPO_EXPERIENCIA_CUMPLE_PPT" id="TIEMPO_EXPERIENCIA_CUMPLE_SI" value="si">
                        <label class="form-check-label" for="TIEMPO_EXPERIENCIA_CUMPLE_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="TIEMPO_EXPERIENCIA_CUMPLE_PPT" id="TIEMPO_EXPERIENCIA_CUMPLE_NO" value="no">
                        <label class="form-check-label" for="TIEMPO_EXPERIENCIA_CUMPLE_NO">No</label>
                    </div>
                </div> 
            </div>
                <!-- V. Habilidades y competencias funcionales -->
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <h4>V. Habilidades y competencias funcionales</h4>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center">Habilidad / Competencia</th>
                            <th class="text-center">Requerido</th>
                            <th class="text-center">Deseable</th>
                            <th class="text-center">No requerido</th>
                            <th class="text-center">Si</th>
                            <th class="text-center">No</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Innovación</td>
                            <td>
                                <input type="text" class="form-control" id="INNOVACION_REQUERIDA_PPT" name="INNOVACION_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="INNOVACION_DESEABLE_PPT" name="INNOVACION_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="INNOVACION_NO_REQUERIDA_PPT" name="INNOVACION_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="INNOVACION_CUMPLE_PPT" id="INNOVACION_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="INNOVACION_CUMPLE_PPT" id="INNOVACION_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Pasión</td>
                            <td>
                                <input type="text" class="form-control" id="PASION_REQUERIDA_PPT" name="PASION_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="PASION_DESEABLE_PPT" name="PASION_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="PASION_NO_REQUERIDA_PPT" name="PASION_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="PASION_CUMPLE_PPT" id="PASION_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="PASION_CUMPLE_PPT" id="PASION_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                         
                          <tr>
                            <td>Servicio (Orientación al cliente)</td>
                            <td>
                                <input type="text" class="form-control" id="SERVICIO_CLIENTE_REQUERIDA_PPT" name="SERVICIO_CLIENTE_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="SERVICIO_CLIENTE_DESEABLE_PPT" name="SERVICIO_CLIENTE_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="SERVICIO_CLIENTE_NO_REQUERIDA_PPT" name="SERVICIO_CLIENTE_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="SERVICIO_CLIENTE_CUMPLE_PPT" id="SERVICIO_CLIENTE_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="SERVICIO_CLIENTE_CUMPLE_PPT" id="SERVICIO_CLIENTE_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Comunicación eficaz</td>
                            <td>
                                <input type="text" class="form-control" id="COMUNICACION_EFICAZ_REQUERIDA_PPT" name="COMUNICACION_EFICAZ_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="COMUNICACION_EFICAZ_DESEABLE_PPT" name="COMUNICACION_EFICAZ_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="COMUNICACION_EFICAZ_NO_REQUERIDA_PPT" name="COMUNICACION_EFICAZ_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="COMUNICACION_EFICAZ_CUMPLE_PPT" id="COMUNICACION_EFICAZ_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="COMUNICACION_EFICAZ_CUMPLE_PPT" id="COMUNICACION_EFICAZ_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Trabajo en equipo</td>
                            <td>
                                <input type="text" class="form-control" id="TRABAJO_EQUIPO_REQUERIDA_PPT" name="TRABAJO_EQUIPO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="TRABAJO_EQUIPO_DESEABLE_PPT" name="TRABAJO_EQUIPO_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="TRABAJO_EQUIPO_NO_REQUERIDA_PPT" name="TRABAJO_EQUIPO_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="TRABAJO_EQUIPO_CUMPLE_PPT" id="TRABAJO_EQUIPO_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="TRABAJO_EQUIPO_CUMPLE_PPT" id="TRABAJO_EQUIPO_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Integridad</td>
                            <td>
                                <input type="text" class="form-control" id="INTEGRIDAD_REQUERIDA_PPT" name="INTEGRIDAD_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="INTEGRIDAD_DESEABLE_PPT" name="INTEGRIDAD_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="INTEGRIDAD_NO_REQUERIDA_PPT" name="INTEGRIDAD_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="INTEGRIDAD_CUMPLE_PPT" id="INTEGRIDAD_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="INTEGRIDAD_CUMPLE_PPT" id="INTEGRIDAD_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Responsabilidad social</td>
                            <td>
                                <input type="text" class="form-control" id="RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT" name="RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="RESPONSABILIDAD_SOCIAL_DESEABLE_PPT" name="RESPONSABILIDAD_SOCIAL_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT" name="RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT" id="RESPONSABILIDAD_SOCIAL_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT" id="RESPONSABILIDAD_SOCIAL_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Adaptabilidad a los cambios del entorno</td>
                            <td>
                                <input type="text" class="form-control" id="ADAPTABILIDAD_REQUERIDA_PPT" name="ADAPTABILIDAD_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="ADAPTABILIDAD_DESEABLE_PPT" name="ADAPTABILIDAD_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="ADAPTABILIDAD_NO_REQUERIDA_PPT" name="ADAPTABILIDAD_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="ADAPTABILIDAD_CUMPLE_PPT" id="ADAPTABILIDAD_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="ADAPTABILIDAD_CUMPLE_PPT" id="ADAPTABILIDAD_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Liderazgo</td>
                            <td>
                                <input type="text" class="form-control" id="LIDERAZGO_REQUERIDA_PPT" name="LIDERAZGO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="LIDERAZGO_DESEABLE_PPT" name="LIDERAZGO_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="LIDERAZGO_NO_REQUERIDA_PPT" name="LIDERAZGO_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="LIDERAZGO_CUMPLE_PPT" id="LIDERAZGO_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="LIDERAZGO_CUMPLE_PPT" id="LIDERAZGO_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                          <tr>
                            <td>Toma de decisiones</td>
                            <td>
                                <input type="text" class="form-control" id="TOMA_DECISIONES_REQUERIDA_PPT" name="TOMA_DECISIONES_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="TOMA_DECISIONES_DESEABLE_PPT" name="TOMA_DECISIONES_DESEABLE_PPT">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="TOMA_DECISIONES_NO_REQUERIDA_PPT" name="TOMA_DECISIONES_NO_REQUERIDA_PPT">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="TOMA_DECISIONES_CUMPLE_PPT" id="TOMA_DECISIONES_CUMPLE_SI" value="Si">
                            </td>
                            <td>
                                <input class="form-check-input" type="radio" name="TOMA_DECISIONES_CUMPLE_PPT" id="TOMA_DECISIONES_CUMPLE_NO" value="no">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                    <!-- VI. Otros -->
                <div class="row mb-3">
                       <div class="col-12 text-center">
                            <h4>VI. Otros</h4>
                       </div>
                  </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Si</th>
                                <th>No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Disponibilidad para viajar</td>
                            <td>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="DISPONIBILAD_VIAJAR_PPT" id="VIAJAR_SI" value="Si">
                                </div>
                            </td>
                                <td>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="DISPONIBILAD_VIAJAR_PPT" id="VIAJAR_NO" value="No">
                                </div>
                            </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td>Requiere pasaporte</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIERE_PASAPORTE_PPT" id="PASAPORTE_SI" value="Si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check"><input class="form-check-input" type="radio" name="REQUIERE_PASAPORTE_PPT" id="PASAPORTE_NO" value="No">
                                    </div>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td>Requiere visa americana</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIERE_VISA_PPT" id="VISA_SI" value="Si">
                                       </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIERE_VISA_PPT" id="VISA_NO" value="No">
                                    </div>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td>Requiere licencia de conducción</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIERE_LICENCIA_PPT" id="LICENCIA_SI" value="Si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIERE_LICENCIA_PPT" id="LICENCIA_NO" value="No">
                                        </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Disponibilidad para cambio de residencia</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="CAMBIO_RESIDENCIA_PPT" id="CAMBIORESIDENCIA_SI" value="Si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="CAMBIO_RESIDENCIA_PPT" id="CAMBIORESIDENCIA_NO" value="No">
                                </div>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Si</th>
                                <th>No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control" id="DISPONIBILADVIAJAR_OPCION_PPT" name="DISPONIBILADVIAJAR_OPCION_PPT">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="1">No</option>
                                        <option value="2">Nacional</option>
                                        <option value="3">Internacional</option>
                                        <option value="4">Nacional-Internac.</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="DISPONIBILADVIAJAR_OPCION_CUMPLE" id="DISPONIBILADVIAJAR_OPCION_SI" value="Si">
                                </div>
                            </td>
                                <td>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="DISPONIBILADVIAJAR_OPCION_CUMPLE" id="DISPONIBILADVIAJAR_OPCION_NO" value="No">
                                </div>
                            </td>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control" id="REQUIEREPASAPORTE_OPCION_PPT" name="REQUIEREPASAPORTE_OPCION_PPT">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="1">No aplica</option>
                                        <option value="2">Deseable</option>
                                        <option value="3">Requerido</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="REQUIEREPASAPORTE_OPCION_CUMPLE" id="REQUIEREPASAPORTE_OPCION_SI" value="Si">
                                </div>
                            </td>
                                <td>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="REQUIEREPASAPORTE_OPCION_CUMPLE" id="REQUIEREPASAPORTE_OPCION_NO" value="No">
                                </div>
                            </td>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control" id="REQUIERE_VISA_OPCION_PPT" name="REQUIERE_VISA_OPCION_PPT">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="1">No aplica</option>
                                        <option value="2">Deseable</option>
                                        <option value="3">Requerido</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIEREVISA_OPCION_CUMPLE" id="REQUIEREVISA_OPCION_SI" value="Si">
                                </div>
                                </td>
                                <td>
                                    <div class="form-check"><input class="form-check-input" type="radio" name="REQUIEREVISA_OPCION_CUMPLE" id="REQUIEREVISA_OPCION_NO" value="No">
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control" id="REQUIERELICENCIA_OPCION_PPT" name="REQUIERELICENCIA_OPCION_PPT">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="1">No aplica</option>
                                        <option value="2">Automovilista</option>
                                        <option value="3">Chofer</option>
                                        <option value="4">Eq. Pesado</option>
                                        <option value="5">Motociclista</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIERELICENCIA_OPCION_CUMPLE" id="REQUIERELICENCIA_OPCION_SI" value="Si">
                                </div>
                            </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="REQUIERELICENCIA_OPCION_CUMPLE" id="REQUIERELICENCIA_OPCION_NO" value="No">
                                </div>
                            </td>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control" id="CAMBIORESIDENCIA_OPCION_PPT" name="CAMBIORESIDENCIA_OPCION_PPT">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="1">No aplica</option>
                                        <option value="2">Nacional</option>
                                        <option value="3">Internacional</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="CAMBIORESIDENCIA_OPCION_CUMPLE" id="CAMBIORESIDENCIA_OPCION_SI" value="Si">
                                </div>
                            </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="CAMBIORESIDENCIA_OPCION_CUMPLE" id="CAMBIORESIDENCIA_OPCION_NO" value="No">
                                </div>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- X. Observaciones -->
                <div class="row mb-3">
                    <div class="col-12 text-center">
                         <h4>X. Observaciones</h4>
                    </div>
               </div>

               <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <textarea class="form-control" id="OBSERVACIONES_PPT" name="OBSERVACIONES_PPT" rows="2"></textarea>
                    </div>
                </div>
               </div>
             <br>
               <div class="row mb-3">
                <div class="col-12 text-center">
                     <h4></h4>
                </div>
               </div>

               <div class="row mb-3">
                <div class="col-4 text-center">
                    <h6>Elaborado por</h6>
                    <input type="text" class="form-control text-center" id="ELABORADO_NOMBRE_PPT" name="ELABORADO_NOMBRE_PPT">
                    <div>Nombre</div>
                    <br>
                    <input type="text" class="form-control text-center" id="ELABORADO_FIRMA_PPT" name="ELABORADO_FIRMA_PPT">
                    <div>Firma</div>
                    <br>
                    <input type="date" class="form-control text-center" id="ELABORADO_FECHA_PPT" name="ELABORADO_FECHA_PPT">
                    <div>Fecha</div>
                    <br>
                </div>
                <div class="col-4 text-center">
                    <h6>Revisado por</h6>
                    <input type="text" class="form-control text-center" id="REVISADO_NOMBRE_PPT" name="REVISADO_NOMBRE_PPT">
                    <div>Nombre</div>
                    <br>
                    <input type="text" class="form-control text-center" id="REVISADO_FIRMA_PPT" name="REVISADO_FIRMA_PPT">
                    <div>Firma</div>
                    <br>
                    <input type="date" class="form-control text-center" id="REVISADO_FECHA_PPT" name="REVISADO_FECHA_PPT">
                    <div>Fecha</div>
                    <br>
                </div>
                <div class="col-4 text-center">
                    <h6>Autorizado por</h6>
                    <input type="text" class="form-control text-center" id="AUTORIZADO_NOMBRE_PPT" name="AUTORIZADO_NOMBRE_PPT">
                    <div>Nombre</div>
                    <br>
                    <input type="text" class="form-control text-center" id="AUTORIZADO_FIRMA_PPT" name="AUTORIZADO_FIRMA_PPT">
                    <div>Firma</div>
                    <br>
                    <input type="date" class="form-control text-center" id="AUTORIZADO_FECHA_PPT" name="AUTORIZADO_FECHA_PPT">
                    <div>Fecha</div>
                    <br>
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