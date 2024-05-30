@extends('principal.maestra')

@section('contenido')



<style>
 /* Estilos adicionales para la tabla */
.table-sm {
    width: 90%; /* Ajustar el ancho de la tabla */
    margin: 0 auto; /* Centrar la tabla */
}

th.header {
    background-color: rgba(0, 124, 186, 0.850); /* Cambiar el color de fondo de las celdas de encabezado */
    color: rgb(0, 0, 0); /* Cambiar el color del texto */
    text-align: center; /* Centrar el texto */
}

/* Estilos de la tabla y los interruptores */
.table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: rgba(0, 124, 186, 0.850); /* Cambiar el color de fondo de las celdas de encabezado */
    color: rgb(0, 0, 0); /* Cambiar el color del texto */
}

.description {
    max-width: 400px;
    word-wrap: break-word;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #FF585D;
}

input:focus + .slider {
    box-shadow: 0 0 1px #FF585D;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.blocked {
    color: gray;
    pointer-events: none;
    opacity: 0.5;
}

.active {
    color: black;
    pointer-events: auto;
    opacity: 1;
}

</style>


    <div class="contenedor-contenido">
      <ol class="breadcrumb mb-5">
          <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Descripción del puesto de trabajo&nbsp;(DPT)</h3>
  
  
          <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_ppt" id="nuevo_dpt" style="margin-left: auto;">
              Nuevo DPT &nbsp;<i class="bi bi-plus-circle"></i>
          </button>
      </ol>
  
      <div class="card-body">
          <table id="TablaDPT" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
  
          </table>
      </div>
  
  </div>





<!-- MODAL  -->
<div class="modal modal-fullscreen fade" id="miModal_DPT" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
          <form method="post" enctype="multipart/form-data" id="formularioDPT" style="background-color: #ffffff;">
              <div class="modal-header">
                  <h5 class="modal-title" id="miModalLabel">Descripción del puesto de trabajo &nbsp;(DPT)</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  {!! csrf_field() !!}
                <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                            <label>Nombre categorías</label>
                            <select class="form-control" id="DEPARTAMENTOS_AREAS_ID" name="DEPARTAMENTOS_AREAS_ID" required>
                              <option value="" disabled selected>Seleccione una opción</option>
                              @foreach ($areas as $area)
                                  <option value="{{ $area->ID }}" data-lugar="{{ $area->LUGAR}}" data-proposito="{{ $area->PROPOSITO }}" data-lider="{{ $area->LIDER }}">{{ $area->NOMBRE }}</option>
                              @endforeach
                          </select>                    
                        </div>
                    </div>
                
                      <div class="col-6">
                          <div class="form-group">
                              <label>Lugar de trabajo  </label>
                              <input type="text" class="form-control" id="AREA_TRABAJO_DPT" name="AREA_TRABAJO_DPT">
                          </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-12 mt-3">
                          <div class="form-group">
                            <label>Propósito o finalidad del puesto</label>
                            <textarea class="form-control" id="PROPOSITO_FINALIDAD_DPT" name="PROPOSITO_FINALIDAD_DPT" rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                          <!-- I. Estructura organizacional -->
                    <div class="row mb-3">
                      <div class="col-12 text-center">
                          <h4>I. Estructura organizacional</h4>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-2">
                        <label>Nivel jerárquico del puesto</label>
                      </div>
                      <div class="col-4">
                          <div class="form-group">
                              <select class="form-control" id="NIVEL_JERARQUICO_DPT" name="NIVEL_JERARQUICO_DPT">
                                <option selected disabled>Seleccione una opción</option>
                                @foreach ($nivel as $niveles)
                                  <option value="{{ $niveles->ID_CATALOGO_JERARQUIA }}">{{ $niveles->NOMBRE_JERARQUIA }}</option>
                              @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="col-2">
                          <label>Puesto al que reporta</label>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="PUESTO_REPORTA_DPT" name="PUESTO_REPORTA_DPT">
                        </div>
                      </div>
                      </div>


                      <div class="row mb-3">
                        <div class="col-2">
                          <label>Puestos que le reportan </label>
                        </div>
                        <div class="col-10">
                          <div class="form-group">
                              <input type="text" class="form-control" id="PUESTO_LE_REPORTAN_DPT" name="PUESTO_LE_REPORTAN_DPT">
                          </div>
                      </div>
                    </div>
                        
                      <div class="row mb-3">
                        <div class="col-2">
                            <label for="puestos-interactuan" class="form-label">Puestos que interactúan</label>
                        </div>
                        
                        <div class="col-10">
                          <select class="custom-select form-control" id="PUESTOS_INTERACTUAN_DPT" name="PUESTOS_INTERACTUAN" required multiple>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->ID }}-{{ $cat->LIDER }}">{{ $cat->NOMBRE }}</option>
                            @endforeach
                        </select>
                      </div>
                      

                        
                      </div>
                      <div class="row mb-3">
                        <div class="col-4">
                          <label for="directos" class="form-label">Directos</label>
                          <input type="text" id="PUESTOS_DIRECTOS_DPT" name="PUESTOS_DIRECTOS_DPT" class="form-control">
                        </div>
                        <div class="col-4">
                            <label for="indirectos" class="form-label">Indirectos</label>
                            <input type="text" id="PUESTOS_INDIRECTOS_DPT" name="PUESTOS_INDIRECTOS_DPT" class="form-control">
                        </div>
                        <div class="col-4 mt-4">
                          <label for="disponibilidad-viajar" class="form-label ml-5">Disponibilidad para viajar</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="DISPONIBILIDAD_VIAJAR" id="DISPONIBILIDAD_CUMPLE_SI" value="si">
                            <label class="form-check-label" for="DISPONIBILIDAD_CUMPLE_SI">Si</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="DISPONIBILIDAD_VIAJAR" id="DISPONIBILIDAD_CUMPLE_NO" value="no">
                            <label class="form-check-label" for="DISPONIBILIDAD_CUMPLE_NO">No</label>
                        </div>
                      </div>
                    </div>

                   
                    

                    <div class="row mb-3">
                      <div class="col-2">
                          <label for="horario-entrada" class="form-label">Horario de entrada</label>
                      </div>
                      <div class="col-4 ">
                          <input type="time" id="HORARIO_ENTRADA_DPT" name="HORARIO_ENTRADA_DPT" class="form-control text-center">
                      </div>
                      <div class="col-2">
                          <label for="horario-salida" class="form-label">Horario de salida</label>
                      </div>
                      <div class="col-4">
                        <input type="time" id="HORARIO_SALIDA_DPT" name="HORARIO_SALIDA_DPT" class="form-control text-center">
                      </div>
                    </div>

                     <!-- II. Funciones y responsabilidades clave del cargo -->
                      <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h4>II. Funciones y responsabilidades clave del cargo</h4>
                        </div>
                      </div>
                      <div class="row mb-3" >
                        <table class="table-sm">
                          <thead>
                              <tr>
                                  <th class="header">Descripción</th>
                                  <th class="header">Activar/Desactivar</th>
                              </tr>
                          </thead>
                          <tbody id="tbodyFucnionesCargo">
                              
                          </tbody>
                      </table>
                      </div>
                
        
                        <!-- III. Funciones y responsabilidades del sistema integrado de gestión (SIG) -->
                      <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h4>III. Funciones y responsabilidades del sistema integrado de gestión (SIG)</h4>
                        </div>
                      </div>
                     
                      <div class="row mb-3">
                        <table class="table-sm">
                          <thead>
                              <tr>
                                  <th class="header">Descripción</th>
                                  <th class="header">Activar/Desactivar</th>
                              </tr>
                          </thead>
                          <tbody id="tbodyFuncionesGestion">
                              
                          </tbody>
                      </table>
                      </div>
                

                        
                         <!-- IV. Relaciones internas estratégicas -->
                      <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h4>IV. Relaciones internas estratégicas</h4>
                        </div>
                      </div>

                      <div class="row mb-3">
                      <div class="col-12">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th style="width: 30%;" class="text-center">Con quién (área y/o puesto en la empresa)</th>
                                      <th style="width: 30%;" class="text-center">Para qué (acción concreta)</th>
                                      <th colspan="5" class="text-center" style="width: 10%;">Frecuencia</th>
                                  </tr>
                                  <tr>
                                      <th></th>
                                      <th></th>
                                      <th style="width: 50%;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN1_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE1_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                  </td>
                                  <td>
                                    <select class="form-control" id="INTERNAS_FRECUENCIA1_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      <option value="Diaria">Diaria</option>
                                      <option value="Semanal">Semanal</option>
                                      <option value="Mensual">Mensual</option>
                                      <option value="Semest.">Semest.</option>
                                      <option value="Anual.">Anual.</option>
                                    </select>
                                  </td>
                                 </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN2_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                               
                                   </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE2_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                  </td>
                                  <td>
                                    <select class="form-control" id="INTERNAS_FRECUENCIA2_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      <option value="Diaria">Diaria</option>
                                      <option value="Semanal">Semanal</option>
                                      <option value="Mensual">Mensual</option>
                                      <option value="Semest.">Semest.</option>
                                      <option value="Anual.">Anual.</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN3_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                                 
                                 </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"  id="INTERNAS_PARAQUE3_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA3_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN4_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                    </select>                                 
                                 </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE4_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA4_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN5_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                                
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE5_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA5_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN6_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                                
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE6_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA6_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
                                      </select>
                                    </td>
                                </tr>

                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN7_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                                
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE7_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA7_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN8_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                                
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE8_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA8_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN9_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                                
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE9_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA9_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
  
                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <select class="form-control area-select" id="INTERNAS_CONQUIEN10_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                                      <option selected disabled>Seleccione una opción</option>
                                      @foreach ($areas as $area)
                                      <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                       @endforeach
                                  </select>                                  
                                </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE10_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <select class="form-control" id="INTERNAS_FRECUENCIA10_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="Diaria">Diaria</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Semest.">Semest.</option>
                                        <option value="Anual.">Anual.</option>
  
                                      </select>
                                    </td>
                                </tr>
                            </tbody>
                              </table>
                            </div>
                        </div>

                         <!-- V. Relaciones externas estratégicas -->
                              <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <h4>V. Relaciones externas estratégicas</h4>
                                </div>
                                </div>
                        
                                <div class="row mb-3">
                                  <div class="col-12">
                                      <table class="table">
                                          <thead>
                                              <tr>
                                                  <th style="width: 30%;" class="text-center">Con quién (cliente, proveedores)</th>
                                                  <th style="width: 30%;" class="text-center">Para qué (acción concreta)</th>
                                                  <th colspan="5" class="text-center" style="width: 10%;">Frecuencia</th>
                                              </tr>
                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="width: 50%;"></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN1_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                                
                                               </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE1_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                              </td>
                                              <td>
                                                <select class="form-control" id="EXTERNAS_FRECUENCIA2_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  <option value="Diaria">Diaria</option>
                                                  <option value="Semanal">Semanal</option>
                                                  <option value="Mensual">Mensual</option>
                                                  <option value="Semest.">Semest.</option>
                                                  <option value="Anual.">Anual.</option>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN2_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                                
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE2_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                              </td>
                                              <td>
                                                <select class="form-control" id="EXTERNAS_FRECUENCIA2_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  <option value="Diaria">Diaria</option>
                                                  <option value="Semanal">Semanal</option>
                                                  <option value="Mensual">Mensual</option>
                                                  <option value="Semest.">Semest.</option>
                                                  <option value="Anual.">Anual.</option>
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN3_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                                
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"  id="EXTERNAS_PARAQUE3_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA3_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN4_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                                
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE4_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA4_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN5_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                               
                                               </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE5_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA5_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN6_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                              
                                                </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE6_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA6_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                            </tr>

                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN7_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                              
                                                </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE7_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA7_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN8_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                               
                                               </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE8_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA8_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN9_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                               
                                               </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE9_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA8_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                              </tr>
                                            <tr>
                                              <td>
                                                <select class="form-control externa-select" id="EXTERNAS_CONQUIEN10_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                                                  <option selected disabled>Seleccione una opción</option>
                                                  @foreach ($externo as $externos)
                                                  <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                                                   @endforeach
                                                </select>                                              
                                                </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE10_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <select class="form-control" id="EXTERNAS_FRECUENCIA10_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <option value="Diaria">Diaria</option>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="Mensual">Mensual</option>
                                                    <option value="Semest.">Semest.</option>
                                                    <option value="Anual.">Anual.</option>
                                                  </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                      </table>
                                      </div>
                                  </div>

                                  
                                            <!-- VI. Competencias básicas o cardinales -->
                                      <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <h4>VI. Competencias básicas o cardinales</h4>
                                        </div>
                                        </div>

                                        <div class="row mb-3">
                                          <div class="col-12">
                                              <table class="table">
                                                  <thead>
                                                      <tr>
                                                          <th style="width: 70%;">Competencia</th>
                                                          <th style="width: 3%;">Bajo</th>
                                                          <th style="width: 3%;">Medio</th>
                                                          <th style="width: 3%;">Alto</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <tr>
                                                          <td><b>1.- Innovación:</b> genera soluciones innovadoras en el ambiente laboral, planteando ideas creativas e incorporando nuevas prácticas para alcanzar mejores resultados.
                                                          </td>
                                                          <td>  
                                                            <input class="form-check-input" type="radio" name="ESCALA_INNOVACION" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                                                          </td>
                                                          <td>
                                                            <input class="form-check-input" type="radio" name="ESCALA_INNOVACION" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                                                          </td>
                                                          <td>
                                                            <input class="form-check-input" type="radio" name="ESCALA_INNOVACION" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                        <td><b>2.- Pasión:</b> muestra compromiso para lograr metas dirigiéndose a las personas, a los equipos que forman parte del trabajo y a la organización,  a fin de obtener el triple resultado (financiero, social y ambiental). Se esfuerza por ser el mejor generador de valor a nuestros clientes, accionistas y empleados.</td>
                                                        <td>
                                                          <input class="form-check-input" type="radio" name="ESCALA_PASION" id="ESCALA_PASION_BAJO" value="BAJO">
                                                        </td>
                                                        <td>
                                                          <input class="form-check-input" type="radio" name="ESCALA_PASION" id="ESCALA_PASION_MEDIO" value="MEDIO">
                                                        </td>
                                                        <td>
                                                          <input class="form-check-input" type="radio" name="ESCALA_PASION" id="ESCALA_PASION_ALTO" value="ALTO">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                      <td><b>3.- Servicio (orientación al cliente):</b> excede las expectativas al esforzarse por conocer y resolver los problemas de los clientes internos/externos; buscando ayudar y obtener relaciones a largo plazo. Crea prácticas que satisfacen las necesidades tanto del cliente como de la organización.</td>
                                                      <td>
                                                        <input class="form-check-input" type="radio" name="ESCALA_SERVICIO" id="ESCALA_SERVICIO_BAJO" value="BAJO">
                                                      </td>
                                                      <td>
                                                        <input class="form-check-input" type="radio" name="ESCALA_SERVICIO" id="ESCALA_SERVICIO_MEDIO" value="MEDIO">
                                                      </td>
                                                      <td>
                                                        <input class="form-check-input" type="radio" name="ESCALA_SERVICIO" id="ESCALA_SERVICIO_ALTO" value="ALTO">
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                    <td><b>4.- Comunicación eficaz:</b> capacidad para escuchar y entender al otro, para transmitir en forma clara y oportuna la información requerida por los demás, a fin de alcanzar los objetivos organizacionales y para mantener canales de comunicación abiertos y redes de contacto formales e informales que abarquen los diferentes niveles de la organización.</td>
                                                    <td>
                                                      <input class="form-check-input" type="radio" name="ESCALA_COMUNICACION" id="ESCALA_COMUNICACION_BAJO" value="BAJO">
                                                    </td>
                                                    <td>
                                                      <input class="form-check-input" type="radio" name="ESCALA_COMUNICACION" id="ESCALA_COMUNICACION_MEDIO" value="MEDIO">
                                                    </td>
                                                    <td>
                                                      <input class="form-check-input" type="radio" name="ESCALA_COMUNICACION" id="ESCALA_COMUNICACION_ALTO" value="ALTO">
                                                    </td>
                                                </tr>
                                                <tr>
                                                  <td><b>5.- Trabajo en equipo:</b> posee la habilidad para participar en una meta común incluso cuando no es de interés personal; tiene la capacidad para comprender la repercusión del trabajo en equipo para mantener relaciones productivas y lograr resultados.</td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_TRABAJO" id="ESCALA_TRABAJO_BAJO" value="BAJO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_TRABAJO" id="ESCALA_TRABAJO_MEDIO" value="MEDIO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_TRABAJO" id="ESCALA_TRABAJO_ALTO" value="ALTO">
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td><b>6.- Integridad:</b> actúa con honestidad, comunicando sus intenciones, ideas y sentimientos de manera abierta y directa. Es conguente con lo que dice y hace con base en los lineamientos establecidos en nuestro código de ética.</td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_INTEGRIDAD" id="ESCALA_INTEGRIDAD_BAJO" value="BAJO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_INTEGRIDAD" id="ESCALA_INTEGRIDAD_MEDIO" value="MEDIO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_INTEGRIDAD" id="ESCALA_INTEGRIDAD_ALTO" value="ALTO">
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td><b>7.- Responsabilidad social:</b> se compromete socialmente con los trabajadores, las comunidades donde interactuamos y el medio ambiente, contribuyendo a la construcción del bien común.</td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_RESPONSABILIDAD" id="ESCALA_RESPONSABILIDAD_BAJO" value="BAJO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_RESPONSABILIDAD" id="ESCALA_RESPONSABILIDAD_MEDIO" value="MEDIO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_RESPONSABILIDAD" id="ESCALA_RESPONSABILIDAD_ALTO" value="ALTO">
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td><b>8.- Adaptabilidad a los cambios del entorno:</b> muestra capacidad para adaptarse a los cambios, mostrando flexibilidad y apertura para alcanzar objetivos cuando surgen dificultades, trabajo eficientemente durante cambios significativos de responsabilidades de puesto o cambios en el medio laboral.</td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_ADAPTIBILIDAD" id="ESCALA_ADAPTIBILIDAD_BAJO" value="BAJO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_ADAPTIBILIDAD" id="ESCALA_ADAPTIBILIDAD_MEDIO" value="MEDIO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_ADAPTIBILIDAD" id="ESCALA_ADAPTIBILIDAD_ALTO" value="ALTO">
                                                  </td>
                                                </tr>
                                                  </tbody>
                                              </table>
                                              </div>
                                          </div>


                              <!-- VII. Competencias gerenciales o de mandos medios -->
                              <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <h4>VII. Competencias gerenciales o de mandos medios</h4>
                                </div>
                                </div>

                                <div class="row mb-3">
                                  <div class="col-12">
                                      <table class="table">
                                          <thead>
                                              <tr>
                                                  <th style="width: 70%;">Competencia</th>
                                                  <th style="width: 3%;">Bajo</th>
                                                  <th style="width: 3%;">Medio</th>
                                                  <th style="width: 3%;">Alto</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td><b>1.- Liderazgo:</b> habilidad necesaria para orientar la acción de los grupos humanos en una dirección determinada, inspirando valores de acción y anticipando escenarios de desarrollo de la acción de ese grupo. Muestra habilidad para fijar objetivos, establece claramente directivas, fija objetivos, prioridades con la capacidad de comunicarlos. Tiene energía la transmite a otros y motiva e inspira confianza.
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_LIDERAZGO" id="ESCALA_LIDERAZGO_BAJO" value="BAJO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_LIDERAZGO" id="ESCALA_LIDERAZGO_MEDIO" value="MEDIO">
                                                  </td>
                                                  <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_LIDERAZGO" id="ESCALA_LIDERAZGO_ALTO" value="ALTO">
                                                  </td>
                                              </tr>
                                              <tr>
                                                <td>2.- Toma de decisiones: capacidad de elegir la mejor opción entre varias para conseguir el objetivo buscado de forma sistemática, comprometiéndose, y siendo coherentes, identifica la causa raíz de los problemas, usa métodos efectivos para seleccionar el curso de acción o las soluciones adecuadas.</td>
                                                <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_TOMADECISION" id="ESCALA_TOMADECISION_BAJO" value="BAJO">
                                                </td>
                                                <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_TOMADECISION" id="ESCALA_TOMADECISION_MEDIO" value="MEDIO">
                                                </td>
                                                <td>
                                                    <input class="form-check-input" type="radio" name="ESCALA_TOMADECISION" id="ESCALA_TOMADECISION_ALTO" value="ALTO">
                                                </td>
                                            </tr>
                                          </tbody>
                                          </table>
                                          </div>
                                        </div>
                                  <!-- VIII. Autoridad -->
                            <div class="row mb-3">
                              <div class="col-12 text-center">
                                  <h4>VIII. Autoridad</h4>
                              </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-6 text-center">
                                    <h6>De información</h6>
                                </div>
                                <div class="col-6 text-center">
                                  <h6>De recursos financieros</h6>
                                </div>
                              </div>
                              <div class="row mb-3">
                                <div class="col-6 text-center">
                                    <h6></h6>
                                </div>
                                <div class="col-6 text-center">
                                  <label>¿Maneja recursos financieros?</label>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-1 text-center">
                                  <h6></h6>
                              </div>
                                <div class="col-2">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="DE_INFORMACION_DPT" id="DEINFORMACION_SI" value="si">
                                    <label class="form-check-label" for="DEINFORMACION_SI">Si</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="DE_INFORMACION_DPT" id="DEINFORMACION_NO" value="no">
                                    <label class="form-check-label" for="DEINFORMACION_NO">No</label>
                                  </div>
                                </div>
                                  <div class="col-3">
                                    <label>Especifique</label>
                                  </div>
                                  <div class="col-1 text-center">
                                    <h6></h6>
                                </div>
                                  <div class="col-2">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="DE_RECURSOS_DPT" id="DERECURSOS_SI" value="si">
                                      <label class="form-check-label" for="DERECURSOS_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="DE_RECURSOS_DPT" id="DERECURSOS_NO" value="no">
                                      <label class="form-check-label" for="DERECURSOS_NO">No</label>
                                    </div>
                                  </div>
                                    <div class="col-3">
                                      <label>Especifique</label>
                                    </div>
                                    </div>
                                      </div>
                                      <div class="row mb-3">
                                        <div class="col-6 text-center">
                                          <textarea class="form-control" id="DE_INFORMACION_ESPECIFIQUE_DPT" name="DE_INFORMACION_ESPECIFIQUE_DPT" rows="2"></textarea>                
                                      </div>
                                        <div class="col-6 text-center">
                                          <textarea class="form-control" id="DE_RECURSOS_ESPECIFIQUE_DPT" name="DE_RECURSOS_ESPECIFIQUE_DPT" rows="2"></textarea> 
                                        </div>
                                      </div>

                                      <div class="row mb-3">
                                        <div class="col-6 text-center">
                                            <h6>De materiales y equipos</h6>
                                        </div>
                                        <div class="col-6 text-center">
                                          <h6>De vehículos</h6>
                                        </div>
                                      </div>

                                      <div class="row mb-3">
                                        <div class="col-6 text-center">
                                          <label>¿Usa materiales y equipos para realizar su trabajo?</label>
                                        </div>
                                        <div class="col-6 text-center">
                                          <label>¿Esta autorizado para conducir vehículos de la empresa?</label>
                                        </div>
                                      </div>

                                      <div class="row mb-3">
                                        <div class="col-1 text-center">
                                          <h6></h6>
                                      </div>
                                        <div class="col-2">
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="DE_EQUIPOS_DPT" id="DEEQUIPOS_SI" value="si">
                                            <label class="form-check-label" for="DEEQUIPOS_SI">Si</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="DE_EQUIPOS_DPT" id="DEEQUIPOS_NO" value="no">
                                            <label class="form-check-label" for="DEEQUIPOS_NO">No</label>
                                          </div>
                                        </div>
                                          <div class="col-3">
                                            <label>Especifique</label>
                                          </div>
                                          <div class="col-1 text-center">
                                            <h6></h6>
                                        </div>
                                          <div class="col-2">
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="DE_VEHICULOS_DPT" id="DEVEHICULOS_SI" value="si">
                                              <label class="form-check-label" for="DEVEHICULOS_SI">Si</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="DE_VEHICULOS_DPT" id="DEVEHICULOS_NO" value="no">
                                              <label class="form-check-label" for="DEVEHICULOS_NO">No</label>
                                            </div>
                                          </div>
                                            <div class="col-3">
                                              <label>Especifique</label>
                                            </div>
                                    </div>

                                <div class="row mb-3">
                                  <div class="col-6 text-center">
                                    <textarea class="form-control" id="DE_EQUIPOS_ESPECIFIQUE_DPT" name="DE_EQUIPOS_ESPECIFIQUE_DPT" rows="2"></textarea>                
                                </div>
                                  <div class="col-6 text-center">
                                    <textarea class="form-control" id="DE_VEHICULOS_ESPECIFIQUE_DPT" name="DE_VEHICULOS_ESPECIFIQUE_DPT" rows="2"></textarea> 
                                  </div>
                                </div>

                                  <!--IX. Observaciones-->
                                  <div class="row mb-3">
                                    <div class="col-12 text-center">
                                        <h4>IX. Observaciones</h4>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="form-control" id="OBSERVACIONES_DPT" name="OBSERVACIONES_DPT" rows="2"></textarea>
                                        </div>
                                    </div>
                                  </div>

                                    <!--X. Organigrama-->
                                  <div class="row mb-3">
                                    <div class="col-12 text-center">
                                        <h4>X. Organigrama</h4>
                                    </div>
                                  </div>

                                  <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="form-control" id="ORGANIGRAMA_DPT" name="ORGANIGRAMA_DPT" rows="5"></textarea>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3 mt-5">
                                    <div class="col-4 text-center">
                                        <h6>Elaborado por</h6>
                                        <input type="text" class="form-control text-center" id="ELABORADO_NOMBRE_DPT" name="ELABORADO_NOMBRE_DPT">
                                        <div>Nombre</div>
                                        <br>
                                        <input type="text" class="form-control text-center" id="ELABORADO_FIRMA_DPT" name="ELABORADO_FIRMA_DPT">
                                        <div>Firma</div>
                                        <br>
                                        <input type="date" class="form-control text-center" id="ELABORADO_FECHA_DPT" name="ELABORADO_FECHA_DPT">
                                        <div>Fecha</div>
                                        <br>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h6>Revisado por</h6>
                                        <input type="text" class="form-control text-center" id="REVISADO_NOMBRE_DPT" name="REVISADO_NOMBRE_DPT">
                                        <div>Nombre</div>
                                        <br>
                                        <input type="text" class="form-control text-center" id="REVISADO_FIRMA_DPT" name="REVISADO_FIRMA_DPT">
                                        <div>Firma</div>
                                        <br>
                                        <input type="date" class="form-control text-center" id="REVISADO_FECHA_DPT" name="REVISADO_FECHA_DPT">
                                        <div>Fecha</div>
                                        <br>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h6>Autorizado por</h6>
                                        <input type="text" class="form-control text-center" id="AUTORIZADO_NOMBRE_DPT" name="AUTORIZADO_NOMBRE_DPT">
                                        <div>Nombre</div>
                                        <br>
                                        <input type="text" class="form-control text-center" id="AUTORIZADO_FIRMA_DPT" name="AUTORIZADO_FIRMA_DPT">
                                        <div>Firma</div>
                                        <br>
                                        <input type="date" class="form-control text-center" id="AUTORIZADO_FECHA_DPT" name="AUTORIZADO_FECHA_DPT">
                                        <div>Fecha</div>
                                        <br>
                                      </div>
                                    </div>

                   </div>
                  <div class="modal-footer mx-5">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success" id="guardarFormDPT">Guardar</button>
              </div>
            </form>
          </div>
      </div>
  </div>
</div>




            @endsection