@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 10px; border-radius: 10px;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i> DPT  </h3>

    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_dpt" id="abrirModalBtn" style="margin-left: auto;">
        Nuevo DPT  <i class="bi bi-plus-circle"></i> 
    </button>
    </ol>
    </div>



  <div class="modal fade" id="exampleModal_DPT" tabindex="-1" aria-labelledby="exampleModalLabel_DPT" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_DPT">Nuevo DPT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label>Nombre del puesto:</label>
                            <input type="text" class="form-control" name="NOMBRE_PUESTO" id="NOMBRE_PUESTO" required>
                        </div>
                        <div class="form-group">
                          <input type="file" name="ARCHIVO_DPT" id="ARCHIVO_DPT" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Guardar</button>
                    </div>
            </div>
        </div>
    </div>



  @endsection