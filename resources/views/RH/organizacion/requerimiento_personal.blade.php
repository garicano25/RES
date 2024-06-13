@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Requisición de personal </h3>

    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_departamento" data-bs-toggle="modal" data-bs-target="#miModal_REQUERIMIENTO" style="margin-left: auto;">
      Nuevo <i class="bi bi-plus-circle"></i>
    </button>

  </ol>

  <div class="card-body">
    <table id="Tablarequerimiento" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
</div>


</div>

<div class="modal modal-fullscreen fade" id="miModal_REQUERIMIENTO" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
        <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioRP" style="background-color: #ffffff;">
          <div class="modal-header">
              <h5 class="modal-title" id="miModalLabel">Requisición de personal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
              {!! csrf_field() !!}
                  <div class="row">
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Fecha:</label>
                                <input type="date" class="form-control " id="FECHA_RP" name="FECHA_RP" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Prioridad:</label>
                                <select class="form-control" id="PRIORIDAD_RP" name="PRIORIDAD_RP" required >
                                  <option selected disabled>Seleccione una opción</option>
                                  <option value="Normal">Normal</option>
                                  <option value="Urgente">Urgente</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tipo de vacante:</label>
                                <select class="form-control" id="TIPO_VACANTE_RP" name="TIPO_VACANTE_RP" required>
                                  <option selected disabled>Seleccione una opción</option>
                                  @foreach ($tipos as $tipo)
                                      <option value="{{ $tipo->ID_CATALOGO_TIPOVACANTE }}">{{ $tipo->NOMBRE_TIPOVACANTE }}</option>
                                  @endforeach
                              </select>                          
                            </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-4">
                          <div class="form-group">
                              <label>Motivo de la vacante:</label>
                              <select class="form-control" id="MOTIVO_VACANTE_RP" name="MOTIVO_VACANTE_RP" required>
                                <option selected disabled>Seleccione una opción</option>
                                <option value="Incremento trabajo">Incremento trabajo</option>
                                <option value="Nueva categoría">Nueva categoría</option>
                                <option value="Cambio de contrato">Cambio de contrato</option>
                                <option value="Promoción">Promoción</option>
                                <option value="Terminación">Terminación</option>
                                <option value="Renuncia">Renuncia</option>
                            </select>                          
                          </div>
                        </div>
                        <div class="col-8">
                          <div class="form-group">
                            <label>Área: </label>
                            <select class="form-control" id="AREA_RP" name="AREA_RP" required>
                              <option selected disabled>Seleccione una opción</option>
                              @foreach ($areas as $area)
                                  <option value="{{ $area->ID_AREA }}">{{ $area->NOMBRE }}</option>
                              @endforeach
                          </select> 
                          </div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-6">
                            <label>Sustituye a: </label>
                              <input type="text" class="form-control " id="SUSTITUYE_RP" name="SUSTITUYE_RP" required>
                        </div>
                        <div class="col-6">
                              <label>Categoría</label>
                              <select class="form-control" id="SUSTITUYE_CATEGORIA_RP" name="SUSTITUYE_CATEGORIA_RP" required>
                                <option selected disabled>Seleccione una opción</option>
                                @foreach ($categoria as $cat)
                                    <option value="{{ $cat->ID_DEPARTAMENTO_AREA }}">{{ $cat->NOMBRE }}</option>
                                @endforeach
                            </select>   
                       
                        </div>
                      </div>

                      {{-- <div class="row mb-3">
                        <div class="col-6">
                          <div class="form-group">
                              <label>Centro de costos:</label>
                              <input type="text" class="form-control " id="CENTRO_COSTO_RP" name="CENTRO_COSTO_RP" required>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                              <label>Área: </label>
                              <select class="form-control" id="AREA_RP" name="AREA_RP" required>
                                <option selected disabled>Seleccione una opción</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->ID_AREA }}">{{ $area->NOMBRE }}</option>
                                @endforeach
                            </select>                         
                          </div>
                        </div>
                      </div> --}}
                      <div class="row mb-3">
                        <div class="col-1">
                          <label></label>
                        </div>
                        <div class="col-2 text-center">
                          <div class="form-group">
                              <label>No. de vacantes</label>
                              <input type="number" class="form-control " id="NO_VACANTES_RP" name="NO_VACANTES_RP" required>
                          </div>
                        </div>
                        <div class="col-1">
                          <label></label>
                        </div>
                        <div class="col-4 text-center">
                          <div class="form-group">
                              <label>Categoría</label>
                              <select class="form-control" id="PUESTO_RP" name="PUESTO_RP" required>
                                <option selected disabled>Seleccione una opción</option>
                                @foreach ($categoria as $cat)
                                    <option value="{{ $cat->ID_DEPARTAMENTO_AREA }}">{{ $cat->NOMBRE }}</option>
                                @endforeach
                            </select>   
                          </div>
                        </div>
                        <div class="col-1">
                          <label></label>
                        </div>
                        <div class="col-2 text-center">
                          <div class="form-group">
                              <label>Fecha de inicio</label>
                              <input type="date" class="form-control " id="FECHA_INICIO_RP" name="FECHA_INICIO_RP" required>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <h4><b>Observaciones</b></h4>
                            </div>
                        </div>
                      </div>
                        <div class="row mb-3">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">1.-</span>
                            <input type="text" class="form-control" id="OBSERVACION1_RP" name="OBSERVACION1_RP">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">2.-</span>
                            <input type="text" class="form-control" id="OBSERVACION2_RP" name="OBSERVACION2_RP">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">3.-</span>
                            <input type="text" class="form-control" id="OBSERVACION3_RP" name="OBSERVACION3_RP">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">4.-</span>
                            <input type="text" class="form-control" id="OBSERVACION4_RP" name="OBSERVACION4_RP">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">5.-</span>
                            <input type="text" class="form-control" id="OBSERVACION5_RP" name="OBSERVACION5_RP">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-5">
                            <label>¿El colaborador utilizará correo electrónico corporativo? </label>
                          </div>
                          <div class="col-4">
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="CORREO_SI">Si</label>
                                <input class="form-check-input" type="radio" name="CORREO_CORPORATIVO_RP" id="CORREO_SI" value="si">
                            </div>
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="CORREO_NO">No</label>
                                <input class="form-check-input" type="radio" name="CORREO_CORPORATIVO_RP" id="CORREO_NO" value="no">
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-5">
                            <label>¿El colaborador utilizará teléfono celular corporativo?  </label>
                          </div>
                          <div class="col-2">
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="TELEFONO_SI">Si</label>
                                <input class="form-check-input" type="radio" name="TELEFONO_CORPORATIVO_RP" id="TELEFONO_SI" value="si">
                            </div>
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="TELEFONO_NO">No</label>
                                <input class="form-check-input" type="radio" name="TELEFONO_CORPORATIVO_RP" id="TELEFONO_NO" value="no">
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-5">
                            <label>¿El colaborador necesita acceso a software de la empresa? </label>
                          </div>
                          <div class="col-2">
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="SOFTWARE_SI">Si</label>
                                <input class="form-check-input" type="radio" name="SOFTWARE_RP" id="SOFTWARE_SI" value="si">
                            </div>
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="SOFTWARE_NO">No</label>
                                <input class="form-check-input" type="radio" name="SOFTWARE_RP" id="SOFTWARE_NO" value="no">
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-5">
                            <label>¿El colaborador conducirá vehículo de la empresa?  </label>
                          </div>
                          <div class="col-2">
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="VEHICULO_SI">Si</label>
                              <input class="form-check-input" type="radio" name="VEHICULO_EMPRESA_RP" id="VEHICULO_SI" value="si">
                            </div>
                            <div class="form-check form-check-inline">
                              <label class="form-check-label" for="VEHICULO_NO">No</label>
                              <input class="form-check-input" type="radio" name="VEHICULO_EMPRESA_RP" id="VEHICULO_NO" value="no">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6 text-center">
                              <label><b>Solicita</b></label>
                            </div>
                            <div class="col-6 text-center">
                              <label><b>Autoriza</b></label>
                            </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-1">
                            <label></label>
                          </div>
                          <div class="col-4">
                            <input type="text"  class="form-control text-center" id="SOLICITA_RP" name="SOLICITA_RP" placeholder="Firma" required>
                          </div>
                          <div class="col-2">
                            <label></label>

                          </div>
                          <div class="col-4">
                            <input type="text"  class="form-control text-center" id="AUTORIZA_RP" name="AUTORIZA_RP" placeholder="Firma">
                          </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-1">
                          <label></label>
                        </div>
                        <div class="col-4">
                          <input type="text"  class="form-control text-center" id="NOMBRE_SOLICITA_RP" name="NOMBRE_SOLICITA_RP" placeholder="Nombre del solicitante"  required>
                        </div>
                        <div class="col-2">
                          <label></label>

                        </div>
                        <div class="col-4 ">
                          <input type="text" class="form-control text-center" id="NOMBRE_AUTORIZA_RP" name="NOMBRE_AUTORIZA_RP" placeholder="Nombre del que Autoriza">
                        </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-1">
                        <label></label>
                      </div>
                      <div class="col-4">
                        <input type="text"  class="form-control text-center" id="CARGO_SOLICITA_RP" name="CARGO_SOLICITA_RP" placeholder="Cargo del Solicitante" required>
                      </div>
                      <div class="col-2">
                        <label></label>

                      </div>
                      <div class="col-4">
                        <input type="text"  class="form-control text-center" id="CARGO_AUTORIZA_RP" name="CARGO_AUTORIZA_RP" placeholder="Cargo del que Autoriza">
                      </div>
                  </div>
                </div>
           </div>
           <div class="modal-footer mx-5">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-success" id="guardarFormRP"><i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar PPT"></i> Guardar</button>
          </div>
      </form>
   </div>
  </div>
</div>

















  @endsection