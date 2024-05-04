@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 10px; border-radius: 10px;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-filetype-ppt"></i> PPT  </h3>
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
          <h5 class="modal-title" id="miModalLabel">Modal Fullscreen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Aquí van los inputs y contenido del modal -->
          <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label>Nombre del puesto</label>
                    <input type="text" class="form-control" id="NOMBRE_PUESTO_PPT" name="NOMBRE_PUESTO_PPT" >
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>Nombre del trabajador</label>
                    <input type="text" class="form-control" id="NOMBRE_TRABAJADOR_PPT" name="NOMBRE_TRABAJADOR_PPT" >
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>Área de trabajador</label>
                    <input type="text" class="form-control" id="AREA_TRABAJADO_PPT" name="AREA_TRABAJADO_PPT" >
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