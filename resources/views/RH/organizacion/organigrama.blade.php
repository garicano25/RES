@extends('principal.maestra')

@section('contenido')


<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 20px; border-radius: 10px;">
    <h2 style="color: #ffffff; margin: 0;"><i class="bi bi-diagram-3-fill"></i> Organigrama  </h2>
  
    <button type="button" class="btn btn-light   waves-effect waves-light botonnuevo_area" id="abrir1ModalBtn" style="margin-left: auto;">
      Departamento   <i class="bi bi-plus-circle"></i>
   </button>

    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_departamento" id="abrirModalBtn" style="margin-left: auto;">
       Área   <i class="bi bi-plus-circle"></i> 
    </button>
  </ol>




            <!--  MODAL AREA -->
        <div class="modal fade" id="exampleModal_area" tabindex="-1" aria-labelledby="exampleModalLabel_area" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_area">Área</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
          
                  <div class="row">         
                      <div class="form-group">
                          <label> Nombre Área: *</label>
                          <input type="text" class="form-control" name="NOMBRE" id="NOMBRE" required>
                      </div>
                      <div class="form-group">
                          <label> Descripción: *</label>
                          <input type="text" class="form-control" name="DESCRIPCION" id="DESCRIPCION" required>
                      </div>
                    <div class="form-group">
                        <label> Tipo Área: *</label>
                        <select class="custom-select form-control" id="TIPO_AREA_ID" name="TIPO_AREA_ID" required>
                            <option selected disabled>Seleccione una opción...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label> Usuarios: *</label>
                        <select class="custom-select form-control" id="USUARIO_ID" name="USUARIO_ID" required>
                            <option selected disabled>Seleccione una opción...</option>
                        </select>
                  </div> 
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger">Guardar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- MODAL DEPARTAMENTOS -->

        <div class="modal fade" id="exampleModal_departamento" tabindex="-1" aria-labelledby="exampleModalLabel_departamento" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_departamento">Departamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
          
                  <div class="row">         
                      <div class="form-group">
                          <label> Nombre Departamento: *</label>
                          <input type="text" class="form-control" name="NOMBRE" id="NOMBRE" required>
                      </div>
                      <div class="form-group">
                          <label> Descripción: *</label>
                          <input type="text" class="form-control" name="DESCRIPCION" id="DESCRIPCION" required>
                      </div>
                    <div class="form-group">
                        <label> Usuarios: *</label>
                        <select class="custom-select form-control" id="USUARIO_ID" name="USUARIO_ID" required>
                            <option selected disabled>Seleccione una opción...</option>
                        </select>
                        <div class="form-group">
                          <label> Área: *</label>
                          <select class="custom-select form-control" id="AREA_ID" name="AREA_ID" required>
                              <option selected disabled>Seleccione una opción...</option>
                          </select>
                    </div>
                  </div> 
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger">Guardar</button>
              </div>
            </div>
          </div>
        </div>


@endsection