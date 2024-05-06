@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 10px; border-radius: 10px;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-diagram-3-fill"></i> Organigrama </h3>






    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_departamento" id="abrirModalBtn" style="margin-left: auto;" data-bs-toggle="modal" data-bs-target="#ModalArea">
      Área <i class="bi bi-plus-circle"></i>
    </button>
  </ol>



  <!-- =========================================================================================================================
                                                   MODALES
========================================================================================================================= -->

  <!--  MODAL AREA -->
  <div class="modal fade" id="ModalArea" tabindex="-1" aria-labelledby="ModalAreaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalAreaTitle">Nueva Area</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-area-tab" data-bs-toggle="tab" data-bs-target="#nav-area" type="button" role="tab" aria-controls="nav-area" aria-selected="true">Area</button>
              <button class="nav-link" id="nav-encargados-tab" data-bs-toggle="tab" data-bs-target="#nav-encargados" type="button" role="tab" aria-controls="nav-encargados" aria-selected="false">Encargados</button>
              <button class="nav-link" id="nav-cargos-tab" data-bs-toggle="tab" data-bs-target="#nav-cargos" type="button" role="tab" aria-controls="nav-cargos" aria-selected="false">Cargos (Departamentos)</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-area" role="tabpanel" aria-labelledby="nav-area-tab" tabindex="0">

              <form id="formArea" class="mt-4">
                <div class="mb-3">
                  <label class="form-label">Nombre del area *</label>
                  <input type="text" class="form-control" id="NOMBRE_AREA" name="NOMBRE_AREA" placeholder="Administración" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Descripción *</label>
                  <textarea class="form-control" id="DESCRIPCION_AREA" name="DESCRIPCION_AREA" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-success mt-2 ">Guardar Area</button>
              </form>
            </div>
            <div class="tab-pane fade" id="nav-encargados" role="tabpanel" aria-labelledby="nav-encargados-tab" tabindex="0">
              <form id="formeEncargado" class="mt-4">
                <div class="mb-3">
                  <label class="form-label">Encargado *</label>
                  <input type="text" class="form-control" id="ENCARGADO_AREA" name="ENCARGADO_AREA" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Cargo *</label>
                  <textarea class="form-control" id="DESCRIPCION_ENCARGADO" name="DESCRIPCION_ENCARGADO" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-success mt-2 ">Guardar Encargado</button>
              </form>
            </div>
            <div class="tab-pane fade" id="nav-cargos" role="tabpanel" aria-labelledby="nav-cargos-tab" tabindex="0">
              <form id="formeDepartamentos" class="mt-4">
                <div class="mb-3">
                  <label class="form-label">Nombre *</label>
                  <input type="text" class="form-control" id="NOMBRE_DEPARTAMENTO" name="NOMBRE_DEPARTAMENTO" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Cargo *</label>
                  <textarea class="form-control" id="DESCRIPCION_ENCARGADO" name="DESCRIPCION_ENCARGADO" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-success mt-2 ">Guardar Encargado</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  @endsection