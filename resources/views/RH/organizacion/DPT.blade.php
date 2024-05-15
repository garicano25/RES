@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i> DPT  </h3>

    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_dpt"  id="actualizarDatos" data-bs-toggle="modal" data-bs-target="#miModal_DPT" style="margin-left: auto;">
      Nuevo DPT  <i class="bi bi-plus-circle"></i> 
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
                  <h5 class="modal-title" id="miModalLabel">Descripción del puesto de trabajo(DPT)</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  {!! csrf_field() !!}
                <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                            <label>Nombre del puesto</label>
                            <select class="form-control" id="DEPARTAMENTOS_AREAS_ID" name="DEPARTAMENTOS_AREAS_ID">
                                <option selected disabled>Seleccione una opción</option>
                                @foreach ($areas as $area)
                                <option value="{{ $area->ID_DEPARTAMENTO_AREA }}">{{ $area->NOMBRE }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                
                      <div class="col-6">
                          <div class="form-group">
                              <label>Área de trabajo</label>
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
                                <option value="Indistinto">Indistinto</option>
                                <option value="Táctico">Táctico</option>
                                <option value="Funcional">Funcional</option>
                                <option value="Operativo">Operativo</option>
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
                        <div class="col-2">
                            <input type="text" id="PUESTOS_INTERACTUAN_DPT" name="PUESTOS_INTERACTUAN_DPT" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="directos" class="form-label">Directos</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="PUESTOS_DIRECTOS_DPT" name="PUESTOS_DIRECTOS_DPT" class="form-control">
                        </div>
                        <div class="col-2">
                            <label for="indirectos" class="form-label">Indirectos</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="PUESTOS_INDIRECTOS_DPT" name="PUESTOS_INDIRECTOS_DPT" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-2">
                          <label for="lugar-trabajo" class="form-label">Lugar de trabajo</label>
                      </div>
                      <div class="col-3">
                          <input type="text" id="LUGAR_TRABAJO_DPT" name="LUGAR_TRABAJO_DPT" class="form-control">
                      </div>
                      <div class="col-2">
                          <label for="disponibilidad-viajar" class="form-label ml-5">Disponibilidad para viajar</label>
                      </div>
                      <div class="col-2">
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
                          <input type="text" id="HORARIO_ENTRADA_DPT" name="HORARIO_ENTRADA_DPT" class="form-control text-center">
                      </div>
                      <div class="col-2">
                          <label for="horario-salida" class="form-label">Horario de salida</label>
                      </div>
                      <div class="col-4">
                        <input type="text" id="HORARIO_SALIDA_DPT" name="HORARIO_SALIDA_DPT" class="form-control text-center">
                      </div>
                    </div>

                     <!-- II. Funciones y responsabilidades clave del cargo -->
                      <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h4>II. Funciones y responsabilidades clave del cargo</h4>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-12 ">
                            <h6>Nota: brevemente describa las responsabilidades del puesto, listando las actividades en orden de importancia. Utilizar verbos en infinitivo como: elaborar, validar, actualizar, enviar, atender, mantener, administrar, entre otros.</h6>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-2">
                            <h5>Funciones del cargo</h5>
                          </div>
                          <div class="col-4">
                            <button type="button" class="btn btn-danger"  id="botonagregarcargo">AGREGAR <i class="bi bi-plus-circle"></i> </button>                          </div>
                      </div>
                      
                      <div id="funciones-responsabilidades-cargo"></div>

                        <!-- III. Funciones y responsabilidades del sistema integrado de gestión (SIG) -->
                      <br><br><br>
                      <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h4>III. Funciones y responsabilidades del sistema integrado de gestión (SIG)</h4>
                        </div>
                      </div>
                        <div class="row mb-3">
                            <div class="col-12 ">
                                <h6>Nota: brevemente describa las responsabilidades del puesto, enlistando las actividades en orden de importancia. Utilizar verbos en infinitivo como: elaborar, validar, actualizar, enviar, atender, mantener, administrar, entre otros.</h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-2">
                            <h5>Funciones  del sistema integrado</h5>
                          </div>
                          <div class="col-4 ">
                              <button type="button" class="btn btn-danger"  id="botonagregargestion">AGREGAR <i class="bi bi-plus-circle"></i> </button>
                          </div>
                      </div>


                      <div id="funciones-responsabilidades-gestion"></div>

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
                                      <th style="width: 2%;">Diaria</th>
                                      <th style="width: 2%;">Semanal</th>
                                      <th style="width: 2%;">Mensual</th>
                                      <th style="width: 2%;">Semest.</th>
                                      <th style="width: 2%;">Anual</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN1_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE1_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA1_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA1_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA1_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA1_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA1_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN2_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE2_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA2_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA2_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA2_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA2_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                  <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA2_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN3_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"  id="INTERNAS_PARAQUE3_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA3_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA3_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA3_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA3_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA3_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN4_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE4_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA4_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA4_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA4_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA4_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA4_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN5_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE5_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA5_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA5_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA5_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA5_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA5_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN6_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE6_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA6_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA6_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA6_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA6_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA6_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                </tr>

                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN7_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE7_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA7_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA7_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA7_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA7_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA7_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN8_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE8_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA8_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA8_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA8_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA8_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA8_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN9_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE9_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA9_DIARIAS_DPT" name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA9_SEMANAL_DPT" name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA9_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA9_SEMESTRAL_DPT" name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA9_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_CONQUIEN10_DPT" name="INTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                  </td>
                                  <td>
                                      <textarea class="form-control"  style="width: 100%;"   id="INTERNAS_PARAQUE10_DPT" name="INTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA10_DIARIAS_DPT" 
                                      name="INTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA10_SEMANAL_DPT" 
                                      name="INTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA10_MENSUAL_DPT" name="INTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA10_SEMESTRAL_DPT"
                                       name="INTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                    </td>
                                    <td>
                                      <input type="text" id="INTERNAS_FRECUENCIA10_ANUAL_DPT" name="INTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
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
                                                  <th style="width: 2%;">Diaria</th>
                                                  <th style="width: 2%;">Semanal</th>
                                                  <th style="width: 2%;">Mensual</th>
                                                  <th style="width: 2%;">Semest.</th>
                                                  <th style="width: 2%;">Anual</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN1_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE1_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA1_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA1_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA1_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA1_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA1_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN2_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE2_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA2_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA2_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA2_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA2_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                              <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA2_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN3_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"  id="EXTERNAS_PARAQUE3_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA3_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA3_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA3_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA3_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA3_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN4_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE4_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA4_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA4_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA4_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA4_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA4_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN5_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE5_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA5_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA5_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA5_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA5_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA5_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN6_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE6_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA6_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA6_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA6_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA6_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA6_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                            </tr>

                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN7_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE7_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA7_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA7_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA7_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA7_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA7_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN8_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE8_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA8_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA8_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA8_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA8_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA8_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN9_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE9_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA9_DIARIAS_DPT" name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA9_SEMANAL_DPT" name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA9_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA9_SEMESTRAL_DPT" name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA9_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_CONQUIEN10_DPT" name="EXTERNAS_CONQUIEN_DPT[]" rows="2"></textarea>
                                              </td>
                                              <td>
                                                  <textarea class="form-control"  style="width: 100%;"   id="EXTERNAS_PARAQUE10_DPT" name="EXTERNAS_PARAQUE_DPT[]"rows="2"></textarea>
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA10_DIARIAS_DPT" 
                                                  name="EXTERNAS_FRECUENCIA_DIARIAS_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA10_SEMANAL_DPT" 
                                                  name="EXTERNAS_FRECUENCIA_SEMANAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA10_MENSUAL_DPT" name="EXTERNAS_FRECUENCIA_MENSUAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA10_SEMESTRAL_DPT"
                                                   name="EXTERNAS_FRECUENCIA_SEMESTRAL_DPT[]" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="EXTERNAS_FRECUENCIA10_ANUAL_DPT" name="EXTERNAS_FRECUENCIA_ANUAL_DPT[]" class="form-control text-center" style="width: 100%;">
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
                                                          <td>1.- Innovación: genera soluciones innovadoras en el ambiente laboral, planteando ideas creativas e incorporando nuevas prácticas para alcanzar mejores resultados.
                                                          </td>
                                                          <td>
                                                            <input type="text" id="INNOVACION_BAJO_DPT" name="INNOVACION_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                          </td>
                                                          <td>
                                                            <input type="text" id="INNOVACION_MEDIO_DPT" name="INNOVACION_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                          </td>
                                                          <td>
                                                            <input type="text" id="INNOVACION_ALTO_DPT" name="INNOVACION_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                        <td>2.- Pasión: muestra compromiso para lograr metas dirigiéndose a las personas, a los equipos que forman parte del trabajo y a la organización,  a fin de obtener el triple resultado (financiero, social y ambiental). Se esfuerza por ser el mejor generador de valor a nuestros clientes, accionistas y empleados.</td>
                                                        <td>
                                                          <input type="text" id="PASION_BAJO_DPT" name="PASION_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                        </td>
                                                        <td>
                                                          <input type="text" id="PASION_MEDIO_DPT" name="PASION_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                        </td>
                                                        <td>
                                                          <input type="text" id="PASION_ALTO_DPT" name="PASION_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                      <td>3.- Servicio (orientación al cliente): excede las expectativas al esforzarse por conocer y resolver los problemas de los clientes internos/externos; buscando ayudar y obtener relaciones a largo plazo. Crea prácticas que satisfacen las necesidades tanto del cliente como de la organización.</td>
                                                      <td>
                                                        <input type="text" id="SERVICIO_BAJO_DPT" name="SERVICIO_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                      </td>
                                                      <td>
                                                        <input type="text" id="SERVICIO_MEDIO_DPT" name="SERVICIO_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                      </td>
                                                      <td>
                                                        <input type="text" id="SERVICIO_ALTO_DPT" name="SERVICIO_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                    <td>4.- Comunicación eficaz: capacidad para escuchar y entender al otro, para transmitir en forma clara y oportuna la información requerida por los demás, a fin de alcanzar los objetivos organizacionales y para mantener canales de comunicación abiertos y redes de contacto formales e informales que abarquen los diferentes niveles de la organización.</td>
                                                    <td>
                                                      <input type="text" id="COMUNICACION_BAJO_DPT" name="COMUNICACION_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                    </td>
                                                    <td>
                                                      <input type="text" id="COMUNICACION_MEDIO_DPT" name="COMUNICACION_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                    </td>
                                                    <td>
                                                      <input type="text" id="COMUNICACION_ALTO_DPT" name="COMUNICACION_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                  <td>5.- Trabajo en equipo: posee la habilidad para participar en una meta común incluso cuando no es de interés personal; tiene la capacidad para comprender la repercusión del trabajo en equipo para mantener relaciones productivas y lograr resultados.</td>
                                                  <td>
                                                    <input type="text" id="TRABAJO_BAJO_DPT" name="TRABAJO_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="TRABAJO_MEDIO_DPT" name="TRABAJO_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="TRABAJO_ALTO_DPT" name="TRABAJO_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>6.- Integridad: actúa con honestidad, comunicando sus intenciones, ideas y sentimientos de manera abierta y directa. Es conguente con lo que dice y hace con base en los lineamientos establecidos en nuestro código de ética.</td>
                                                  <td>
                                                    <input type="text" id="INTEGRIDAD_BAJO_DPT" name="INTEGRIDAD_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="INTEGRIDAD_MEDIO_DPT" name="INTEGRIDAD_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="INTEGRIDAD_ALTO_DPT" name="INTEGRIDAD_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>7.- Responsabilidad social: se compromete socialmente con los trabajadores, las comunidades donde interactuamos y el medio ambiente, contribuyendo a la construcción del bien común.</td>
                                                  <td>
                                                    <input type="text" id="RESPONSABILIDAD_BAJO_DPT" name="RESPONSABILIDAD_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="RESPONSABILIDAD_MEDIO_DPT" name="RESPONSABILIDAD_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="RESPONSABILIDAD_ALTO_DPT" name="RESPONSABILIDAD_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td>8.- Adaptabilidad a los cambios del entorno: muestra capacidad para adaptarse a los cambios, mostrando flexibilidad y apertura para alcanzar objetivos cuando surgen dificultades, trabajo eficientemente durante cambios significativos de responsabilidades de puesto o cambios en el medio laboral.</td>
                                                  <td>
                                                    <input type="text" id="ADAPTABILIDAD_BAJO_DPT" name="ADAPTABILIDAD_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="ADAPTABILIDAD_MEDIO_DPT" name="ADAPTABILIDAD_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="ADAPTABILIDAD_ALTO_DPT" name="ADAPTABILIDAD_ALTO_DPT" class="form-control text-center" style="width: 100%;">
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
                                                  <td>1.- Liderazgo: habilidad necesaria para orientar la acción de los grupos humanos en una dirección determinada, inspirando valores de acción y anticipando escenarios de desarrollo de la acción de ese grupo. Muestra habilidad para fijar objetivos, establece claramente directivas, fija objetivos, prioridades con la capacidad de comunicarlos. Tiene energía la transmite a otros y motiva e inspira confianza.
                                                  </td>
                                                  <td>
                                                    <input type="text" id="LIDERAZGO_BAJO_DPT" name="LIDERAZGO_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="LIDERAZGO_MEDIO_DPT" name="LIDERAZGO_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                                  <td>
                                                    <input type="text" id="LIDERAZGO_ALTO_DPT" name="LIDERAZGO_ALTO_DPT" class="form-control text-center" style="width: 100%;">
                                                  </td>
                                              </tr>
                                              <tr>
                                                <td>2.- Toma de decisiones: capacidad de elegir la mejor opción entre varias para conseguir el objetivo buscado de forma sistemática, comprometiéndose, y siendo coherentes, identifica la causa raíz de los problemas, usa métodos efectivos para seleccionar el curso de acción o las soluciones adecuadas.</td>
                                                <td>
                                                  <input type="text" id="TOMADECISION_BAJO_DPT" name="TOMADECISION_BAJO_DPT" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="TOMADECISION_MEDIO_DPT" name="TOMADECISION_MEDIO_DPT" class="form-control text-center" style="width: 100%;">
                                                </td>
                                                <td>
                                                  <input type="text" id="TOMADECISION_ALTO_DPT" name="TOMADECISION_ALTO_DPT" class="form-control text-center" style="width: 100%;">
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
                                <div class="col-1 text-center ">
                                  <label>Si</label>
                                </div>
                                <div class="col-1">
                                  <input type="text" id="DE_INFORMACION_SI_DPT" name="DE_INFORMACION_SI_DPT" class="form-control text-center">
                                </div>
                                <div class="col-1 text-center ">
                                  <label>No</label>
                                </div>
                                <div class="col-1">
                                <input type="text" id="DE_INFORMACION_NO_DPT" name="DE_INFORMACION_NO_DPT" class="form-control text-center">
                              </div>
                                <div class="col-3">
                                <label>Especifique</label>
                                </div>
                                <div class="col-1 text-center ">
                                  <label>Si</label>
                              </div>
                              <div class="col-1">
                                <input type="text" id="DE_RECURSOS_SI_DPT" name="DE_RECURSOS_SI_DPT" class="form-control text-center">
                              </div>
                              <div class="col-1 text-center ">
                                <label>No</label>
                              </div>
                            <div class="col-1">
                              <input type="text" id="DE_RECURSOS_NO_DPT" name="DE_RECURSOS_NO_DPT" class="form-control text-center">
                            </div>
                            <div class="col-1">
                              <label>Especifique</label>
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
                                <div class="col-1 text-center ">
                                  <label>Si</label>
                                </div>
                                <div class="col-1">
                                  <input type="text" id="DE_EQUIPOS_SI_DPT" name="DE_EQUIPOS_SI_DPT" class="form-control text-center">
                                </div>
                                <div class="col-1 text-center ">
                                  <label>No</label>
                                </div>
                                <div class="col-1">
                                <input type="text" id="DE_EQUIPOS_NO_DPT" name="DE_EQUIPOS_NO_DPT" class="form-control text-center">
                              </div>
                                <div class="col-3">
                                <label>Especifique</label>
                                </div>
                              <div class="col-1 text-center ">
                                    <label>Si</label>
                              </div>
                              <div class="col-1">
                                <input type="text" id="DE_VEHICULOS_SI_DPT" name="DE_VEHICULOS_SI_DPT" class="form-control text-center">
                              </div>
                              <div class="col-1 text-center ">
                                <label>No</label>
                              </div>
                            <div class="col-1">
                              <input type="text" id="DE_VEHICULOS_NO_DPT" name="DE_VEHICULOS_NO_DPT" class="form-control text-center">
                            </div>
                            <div class="col-1">
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
              </div>
            <div class="modal-footer mx-5">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success" id="guardarFormDPT">Guardar</button>
              </div>
          </form>
      </div>
  </div>
</div>




            @endsection