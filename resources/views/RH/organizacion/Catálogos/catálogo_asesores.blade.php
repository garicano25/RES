@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-people-fill"></i>&nbsp;Asesores</h3>


        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_asesores" data-bs-toggle="modal" data-bs-target="#miModal_ASESORES" style="margin-left: auto;">
            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    {{-- <div class="card-body">
        <table id="Tablajerarquia" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div> --}}

</div>


<div class="modal fade" id="miModal_ASESORES" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" enctype="multipart/form-data" id="formularioASESOR" style="background-color: #ffffff;">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Asesores</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! csrf_field() !!}
                <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Nombre Asesor *</label>
                <input type="text" class="form-control" id="NOMBRE_ASESOR" name="NOMBRE_ASESOR" required>
                </div>
                <div class="mb-3">
                <label for="message-text" class="col-form-label">Descripción:</label>
                <textarea class="form-control" id="DESCRIPCION_ASESOR" name="DESCRIPCION_ASESOR" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="disponibilidad-viajar" class="form-label ml-5">Es &nbsp;</label>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="ASESOR_ES" id="INTERNO_SI" value="1">
                      <label class="form-check-label" for="INTERNO_SI">Interno</label>
                  </div>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="ASESOR_ES" id="EXTERNO_NO" value="0">
                      <label class="form-check-label" for="EXTERNO_NO">Externo</label>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" id="guardarFormASESOR">Guardar</button>
            </div>
          </form>
      </div>
    </div>
  </div>
















@endsection