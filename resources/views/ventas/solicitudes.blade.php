@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-pencil-fill"></i>&nbsp;Solicitudes</h3>

    <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_SOLICITUDES" style="margin-left: auto;">
      Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
    </button>

  </ol>

  <div class="card-body">
    <table id="Tablasolicitudes" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>


</div>











<div class="modal modal-fullscreen fade" id="miModal_SOLICITUDES" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioSOLICITUDES" style="background-color: #ffffff;">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel">Solicitudes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {!! csrf_field() !!}
          <div class="row">

            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mb-3 text-center">
                  <h5 class="form-label">Datos de la solicitud </h5>
                </div>
              </div>
            </div>


            <div class="col-12">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">Tipo de Solicitud *</label>
                  <select class="form-select" id="TIPO_SOLICITUD" name="TIPO_SOLICITUD" required>
                    <option selected disabled>Seleccione una opción</option>
                    <option value="1">Pasiva</option>
                    <option value="2">Activa</option>
                  </select>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="form-label">Solicitud No.</label>
                  <input type="text" class="form-control" id="NO_SOLICITUD" name="NO_SOLICITUD" readonly>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Fecha *</label>
                  <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                  </div>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="form-label">Medio de Contacto *</label>
                  <input type="text" class="form-control" id="MEDIO_CONTACTO_SOLICITUD" name="MEDIO_CONTACTO_SOLICITUD" required>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">Razón Social *</label>
                  <input type="text" class="form-control" id="RAZON_SOCIAL_SOLICITUD" name="RAZON_SOCIAL_SOLICITUD" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Nombre Comercial *</label>
                  <input type="text" class="form-control" id="NOMBRE_COMERCIAL_SOLICITUD" name="NOMBRE_COMERCIAL_SOLICITUD" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Giro de la Empresa *</label>
                  <input type="text" class="form-control" id="GIRO_EMPRESA_SOLICITUD" name="GIRO_EMPRESA_SOLICITUD" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Representante Legal *</label>
                  <input type="text" class="form-control" id="REPRESENTANTE_LEGAL_SOLICITUD" name="REPRESENTANTE_LEGAL_SOLICITUD" required>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label class="form-label">Dirección *</label>
                  <input type="text" class="form-control" id="DIRECCION_SOLICITUD" name="DIRECCION_SOLICITUD" required>
                </div>
              </div>
            </div>



            <div class="col-12">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Necesidad del Servicio *</label>
                  <input type="text" class="form-control" id="NECESIDAD_SERVICIO_SOLICITUD" name="NECESIDAD_SERVICIO_SOLICITUD" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Servicio Solicitado *</label>
                  <input type="text" class="form-control" id="SERVICIO_SOLICITADO_SOLICITUD" name="SERVICIO_SOLICITADO_SOLICITUD" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Tipo de Cliente *</label>
                  <select class="form-select" id="TIPO_CLIENTE_SOLICITUD" name="TIPO_CLIENTE_SOLICITUD" required>
                    <option selected disabled>Seleccione una opción</option>
                    <option value="1">Prospecto</option>
                    <option value="2">Existente</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Observaciones de la Solicitud</label>
                <textarea class="form-control" id="OBSERVACIONES_SOLICITUD" name="OBSERVACIONES_SOLICITUD" rows="4"></textarea>
              </div>
            </div>



            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mb-3 text-center">
                  <h5 class="form-label">Datos del contacto </h5>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre *</label>
                  <input type="text" class="form-control" id="CONTACTO_SOLICITUD" name="CONTACTO_SOLICITUD" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Cargo *</label>
                  <input type="text" class="form-control" id="CARGO_SOLICITUD" name="CARGO_SOLICITUD" required>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Teléfono y Extensión </label>
                  <input type="text" class="form-control" id="TELEFONO_SOLICITUD" name="TELEFONO_SOLICITUD">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Celular *</label>
                  <input type="text" class="form-control" id="CELULAR_SOLICITUD" name="CELULAR_SOLICITUD" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Correo electronico *</label>
                  <input type="email" class="form-control" id="CORREO_SOLICITUD" name="CORREO_SOLICITUD" required>
                </div>
              </div>
            </div>


            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mb-3 text-center">
                  <h5 class="form-label">A quien se dirige la oferta</h5>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="DIRIGE_OFERTA" id="mismoContacto" value="1" onchange="handleRadioChange()">
                    <label class="form-check-label" for="mismoContacto">Mismo contacto</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="DIRIGE_OFERTA" id="aQuienCorresponda" value="0" onchange="handleRadioChange()">
                    <label class="form-check-label" for="aQuienCorresponda">A quien corresponda</label>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-12">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre *</label>
                  <input type="text" class="form-control" id="CONTACTO_OFERTA" name="CONTACTO_OFERTA" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Cargo *</label>
                  <input type="text" class="form-control" id="CARGO_OFERTA" name="CARGO_OFERTA" required>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Teléfono y Extensión </label>
                  <input type="text" class="form-control" id="TELEFONO_OFERTA" name="TELEFONO_OFERTA">
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Celular *</label>
                  <input type="text" class="form-control" id="CELULAR_OFERTA" name="CELULAR_OFERTA" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Correo electronico *</label>
                  <input type="email" class="form-control" id="CORREO_OFERTA" name="CORREO_OFERTA" required>
                </div>
              </div>
            </div>



            <div class="col-12" id="RECHAZO" style="display: none;">
              <div class="mb-3">
                <label class="form-label">Motivo del rechazo</label>
                <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="4" readonly></textarea>
              </div>
            </div>



          </div>
        </div>

        <div class="modal-footer mx-5">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="guardarSOLICITUD">
            <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar solicitud"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/th





@endsection