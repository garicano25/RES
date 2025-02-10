@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-patch-check-fill"></i>&nbsp;Confirmación del servicio </h3>

        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVA_CONFIRMACION" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>

    </ol>

    <div class="card-body">
        <table id="Tablaconfirmacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>


</div>










<div class="modal modal-fullscreen fade" id="miModal_CONFIRMACION" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCONFIRMACION" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Confirmación del servicio </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">


                        <div class="mb-3">
                            <label>N° de oferta</label>
                            <select class="custom-select form-control" id="OFERTA_ID" name="OFERTA_ID">
                                <option selected disabled>Seleccione una cotización</option>
                                @foreach($solicitudes as $solicitud)
                                <option value="{{ $solicitud->ID_FORMULARIO_OFERTAS }}">
                                    {{ $solicitud->NO_OFERTA }}
                                </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-12 mt-3">
                            <div class="row">

                                <div class="col-6">
                                    <label>Forma de aceptación *</label>
                                    <select class="form-control" id="ACEPTACION_CONFIRMACION" name="ACEPTACION_CONFIRMACION" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">Firma</option>
                                        <option value="2">OC/OS</option>
                                        <option value="3">Contrato</option>
                                    </select>
                                </div>


                                <div class="col-6">
                                    <label>Fecha de aceptación *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_CONFIRMACION" name="FECHA_CONFIRMACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-4 mt-3">
                                    <label class="form-label">Quién acepta *</label>
                                    <input type="text" class="form-control" name="QUIEN_ACEPTA" id="QUIEN_ACEPTA" required>
                                </div>
                                <div class="col-4 mt-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="CARGO_ACEPTACION" id="CARGO_ACEPTACION" required>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Subir documento de aceptación (PDF) *</label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control me-2" name="DOCUMENTO_ACEPTACION" id="DOCUMENTO_ACEPTACION" accept=".pdf">
                                        <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label>No. OC/OS/Contrato </label>
                                    <input type="text" class="form-control" id="NO_CONFIRMACION" name="NO_CONFIRMACION">
                                </div>

                                <div class="col-4">
                                    <label>Fecha de emisión *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_EMISION" name="FECHA_EMISION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label>Fecha de validación *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VALIDACION" name="FECHA_VALIDACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="mb-3 mt-3">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label>Agregar evidencia</label>
                                        <button id="botonVerificacion" id="botonVerificacion" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="verifiacionesdiv mt-4"></div>
                            </div>

                        </div>




                        <div class="d-flex align-items-center mt-3">
                            <h5 class="me-2">Validar información</h5>
                            <button id="btnVerificacion" type="button" class="btn btn-info btn-custom rounded-pill">
                                <i class="bi bi-check"></i>
                            </button>
                        </div>
                        <input type="hidden" id="inputVerificacionEstado" name="ESTADO_VERIFICACION" value="0">



                        <div id="VERIFICACION_CLIENTE" style="display: none;">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Quién valida *</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}" readonly>
                                    </div>

                                    <div class="col-md-4 mt-2">
                                        <label>Fecha de Validación *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VERIFICACION_CONFIRMACION" name="FECHA_VERIFICACION_CONFIRMACION">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Comentario *</label>
                                        <textarea class="form-control" name="COMENTARIO_VALIDACION" id="COMENTARIO_VALIDACION" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Lista de Verificación con Radios e Input alineados -->
                            <div class="col-12 mt-3">
                                <h5 class="mb-2"><b>Verificación de Información</b></h5>

                                <div class="row">
                                    <!-- Opciones de verificación -->
                                    <div class="col-12">
                                        <div class="row">
                                            <!-- Razón Social -->
                                            <div class="col-12 d-flex align-items-center gap-3 mb-2">
                                                <label class="form-check-label" style="min-width: 150px;">Razón Social</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="RAZON_SOCIAL_VERIFICACION" value="Sí" required onclick="toggleInput('razonSocialInput', false)"> Sí
                                                    <input class="form-check-input" type="radio" name="RAZON_SOCIAL_VERIFICACION" value="No" onclick="toggleInput('razonSocialInput', true)"> No
                                                </div>
                                                <input type="text" id="razonSocialInput" class="form-control d-none" placeholder="Motivo">
                                            </div>

                                            <!-- RFC -->
                                            <div class="col-12 d-flex align-items-center gap-3 mb-2">
                                                <label class="form-check-label" style="min-width: 150px;">RFC</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="RFC_VERIFICACION" value="Sí" required onclick="toggleInput('rfcInput', false)"> Sí
                                                    <input class="form-check-input" type="radio" name="RFC_VERIFICACION" value="No" onclick="toggleInput('rfcInput', true)"> No
                                                </div>
                                                <input type="text" id="rfcInput" class="form-control d-none" placeholder="Motivo">
                                            </div>

                                            <!-- Precios -->
                                            <div class="col-12 d-flex align-items-center gap-3 mb-2">
                                                <label class="form-check-label" style="min-width: 150px;">Precios</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="PRECIOS_VERIFICACION" value="Sí" required onclick="toggleInput('preciosInput', false)"> Sí
                                                    <input class="form-check-input" type="radio" name="PRECIOS_VERIFICACION" value="No" onclick="toggleInput('preciosInput', true)"> No
                                                </div>
                                                <input type="text" id="preciosInput" class="form-control d-none" placeholder="Motivo">
                                            </div>

                                            <!-- Moneda -->
                                            <div class="col-12 d-flex align-items-center gap-3 mb-2">
                                                <label class="form-check-label" style="min-width: 150px;">Moneda</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="MONEDA_VERIFICACION" value="Sí" required onclick="toggleInput('monedaInput', false)"> Sí
                                                    <input class="form-check-input" type="radio" name="MONEDA_VERIFICACION" value="No" onclick="toggleInput('monedaInput', true)"> No
                                                </div>
                                                <input type="text" id="monedaInput" class="form-control d-none" placeholder="Motivo">
                                            </div>

                                            <!-- Cantidad -->
                                            <div class="col-12 d-flex align-items-center gap-3 mb-2">
                                                <label class="form-check-label" style="min-width: 150px;">Cantidad</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="CANTIDAD_VERIFICACION" value="Sí" required onclick="toggleInput('cantidadInput', false)"> Sí
                                                    <input class="form-check-input" type="radio" name="CANTIDAD_VERIFICACION" value="No" onclick="toggleInput('cantidadInput', true)"> No
                                                </div>
                                                <input type="text" id="cantidadInput" class="form-control d-none" placeholder="Motivo">
                                            </div>

                                            <!-- Servicios -->
                                            <div class="col-12 d-flex align-items-center gap-3 mb-2">
                                                <label class="form-check-label" style="min-width: 150px;">Servicios</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input"  type="radio" name="SERVICIO_VERIFICACION" value="Sí" required onclick="toggleInput('servicioInput', false)"> Sí
                                                    <input class="form-check-input" type="radio" name="SERVICIO_VERIFICACION" value="No" onclick="toggleInput('servicioInput', true)"> No
                                                </div>
                                                <input type="text" id="servicioInput" class="form-control d-none" placeholder="Motivo">
                                            </div>

                                            <!-- Días de crédito -->
                                            <div class="col-12 d-flex align-items-center gap-3 mb-2">
                                                <label class="form-check-label" style="min-width: 150px;">Días de Crédito</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="DIAS_CREDITO_VERIFICACION" value="Sí" required onclick="toggleInput('diasCreditoInput', false)"> Sí
                                                    <input class="form-check-input"  type="radio" name="DIAS_CREDITO_VERIFICACION" value="No" onclick="toggleInput('diasCreditoInput', true)"> No
                                                </div>
                                                <input type="text" id="diasCreditoInput" class="form-control d-none" placeholder="Motivo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <h5 class="form-label"><b>Se procede a generar la orden de trabajo </b></h5>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="PROCEDE_ORDEN" id="procedeno" value="0">
                                        <label class="form-check-label" for="procedeno">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="PROCEDE_ORDEN" id="procedesi" value="1">
                                        <label class="form-check-label" for="procedesi">Sí</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCONFIRMACION">
                        <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Confirmación del servicio "></i> Guardar
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