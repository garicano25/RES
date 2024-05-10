@extends('principal.maestra')

@section('contenido')

<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-diagram-3-fill"></i> Organigrama </h3>

    <button type="button" class="btn btn-light waves-effect waves-light" id="verOrganigramaGeneral" style="margin-left: 35px;">
      Organigrama General <i class="bi bi-eye"></i>
    </button>

    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_departamento" id="abrirModalBtn" style="margin-left: auto;" data-bs-toggle="modal" data-bs-target="#ModalArea">
      Área <i class="bi bi-plus-circle"></i>
    </button>
  </ol>


  <div class="card-body">
    <table id="TablaAreas" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>



  <!-- =========================================================================================================================
                                                   MODALES
  ========================================================================================================================= -->
  <!--  MODAL AREA -->
  <div class="modal fade" id="ModalArea" tabindex="-1" aria-labelledby="ModalAreaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalAreaTitle">Nueva Área</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-area-tab" data-bs-toggle="tab" data-bs-target="#nav-area" type="button" role="tab" aria-controls="nav-area" aria-selected="true">Área</button>
              <button class="nav-link" id="nav-encargados-tab" data-bs-toggle="tab" data-bs-target="#nav-encargados" type="button" role="tab" aria-controls="nav-encargados" aria-selected="false" disabled>Encargados</button>
              <button class="nav-link" id="nav-cargos-tab" data-bs-toggle="tab" data-bs-target="#nav-cargos" type="button" role="tab" aria-controls="nav-cargos" aria-selected="false" disabled>Cargos (Departamentos)</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-area" role="tabpanel" aria-labelledby="nav-area-tab" tabindex="0">
              <!-- Formulario de Area -->
              <form id="formArea" class="mt-4">
                {!! csrf_field() !!}
                <input type="hidden" name="TIPO_AREA_ID" value="3">

                <div class="mb-3">
                  <label class="form-label">Nombre del área *</label>
                  <input type="text" class="form-control" id="NOMBRE_AREA" name="NOMBRE" placeholder="ejem: Administración" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Descripción </label>
                  <textarea class="form-control" id="DESCRIPCION_AREA" name="DESCRIPCION" rows="2"></textarea>
                </div>

                <button type="submit" id="guardarArea" class="btn btn-success mt-2 ">Guardar </button>
              </form>
            </div>
            <div class="tab-pane fade" id="nav-encargados" role="tabpanel" aria-labelledby="nav-encargados-tab" tabindex="0">
              <!-- Formulario de encargado -->
              <form id="formEncargado" class="mt-4">
                {!! csrf_field() !!}
                <input type="hidden" name="TIPO_AREA_ID" value="4">

                <div class="row">
                  <div class="col-10">
                    <div class="mb-3">
                      <label class="form-label">Descripción del cargo *</label>
                      <input type="text" class="form-control" id="NOMBRE_CARGO" name="NOMBRE_CARGO" required>
                    </div>
                  </div>
                  <div class="col-2 mt-4">
                    <button type="submit" id="guardarEncargado" class="btn btn-success mt-2 ">Guardar</button>
                  </div>
                </div>
              </form>

              <!-- Tabla de los encargados -->
              <table id="TablaEncargados" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

              </table>
            </div>
            <div class="tab-pane fade" id="nav-cargos" role="tabpanel" aria-labelledby="nav-cargos-tab" tabindex="0">
              <!-- Formulario de cargo -->
              <form id="formDepartamentos" class="mt-4 mb-4">
                {!! csrf_field() !!}
                <input type="hidden" name="TIPO_AREA_ID" value="5">
                <div class="row">
                  <div class="col-4 mt-3">
                    <label class="form-label">¿Depende de un encargado? *</label>
                    <div class="form-check form-check-inline mx-3">
                      <input class="form-check-input" type="radio" name="TIENE_ENCARGADO" id="TIENE_ENCARGADO_SI" value="1" checked>
                      <label class="form-check-label" for="TIENE_ENCARGADO_SI">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="TIENE_ENCARGADO" id="TIENE_ENCARGADO_NO" value="0">
                      <label class="form-check-label" for="TIENE_ENCARGADO_NO">No</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-floating">
                      <select class="form-select" id="ENCARGADO_AREA_ID" name="ENCARGADO_AREA_ID"></select>
                      <label for="ENCARGADO_AREA_ID">Encargado del Departamento</label>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-10">
                    <div class="mb-3">
                      <input type="text" class="form-control" id="CARGO_DESCRIPCION" name="NOMBRE" placeholder="Descripcion del cargo" required>
                    </div>

                  </div>
                  <div class="col-2 ">
                    <button type="submit" id="guardarDepartamento" class="btn btn-success mt-2 ">Guardar</button>
                  </div>
                </div>
              </form>
              <!-- Tabla de las cargas -->
              <table id="TablaCargos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom mt-3">

              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal del organigrama -->
  <div class="modal fade" id="modalOrganigrama" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="TituloModalOrganigrma"></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


          <div class="md:flex flex-col md:flex-row md:min-h-screen w-full mx-auto">

            <div id="allSampleContent" class="p-4 w-full ">

              <style type="text/css">
                #myOverviewDiv {
                  position: absolute;
                  width: 200px;
                  height: 100px;
                  top: 10px;
                  left: 10px;
                  background-color: #f2f2f2;
                  z-index: 300;
                  /* make sure its in front */
                  border: solid 1px #7986cb;

                }
              </style>


              <div id="sample" style="position: relative;" class="justify-content-center align-items-center">
                <div id="myDiagramDiv" style="background-color: #ffffff; width: 100%; height: 77rem"></div>
                <div id="myOverviewDiv"></div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-success">Capturar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection