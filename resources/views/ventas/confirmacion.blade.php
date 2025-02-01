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
                            <select class="custom-select form-control" id="SOLICITUD_ID" name="SOLICITUD_ID">
                                <option selected disabled>Seleccione una solicitud</option>
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



                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-6">
                                    <label>No. OC/OS/Contrato </label>
                                    <input type="text" class="form-control" id="NO_CONFIRMACION" name="NO_CONFIRMACION">
                                </div>

                                <div class="col-6">
                                    <label>Fecha de emisión *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_CONFIRMACION" name="FECHA_CONFIRMACION" required>
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



                        <div class="col-12 mt-3">
                            <div class="row">

                                <div class="col-3">
                                    <label>Verificado por (iniciales personal RES) </label>
                                    <input type="text" class="form-control" id="VERIFICACION_CONFIRMACION" name="VERIFICACION_CONFIRMACION">
                                </div>

                                <div class="col-3">
                                    <label>Fecha de verificación de OC/OS/Contrato*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VERIFICACION_CONFIRMACION" name="FECHA_VERIFICACION_CONFIRMACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label>Prioridad del servicio (Normal - Urgente) </label>
                                    <input type="text" class="form-control" id="PRIORIDAD_CONFIRMACION" name="PRIORIDAD_CONFIRMACION">
                                </div>


                                <div class="col-3">
                                    <label>Fecha de inicio del servicio*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO_CONFIRMACION" name="FECHA_INICIO_CONFIRMACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
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

                                    <div class="col-4 mt-2">
                                        <label>Fecha de Validación *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VERIFICACION_CONFIRMACION" name="FECHA_VERIFICACION_CONFIRMACION" required>
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Comentario *</label>
                                        <textarea class="form-control" name="COMENTARIO_VALIDACION" rows="1" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Lista de Verificación con Radio Buttons Alineados -->
                            <div class="col-12 mt-3">
                                <h5 class="mb-2"><b>Verificación de Información</b></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-end">Razón Social</label>
                                            <div class="ms-3">
                                                <input type="radio" name="RAZON_SOCIAL_VERIFICACION" value="Sí" required> Sí
                                                <input type="radio" name="RAZON_SOCIAL_VERIFICACION" value="No"> No
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-end">RFC</label>
                                            <div class="ms-3">
                                                <input type="radio" name="RFC_VERIFICACION" value="Sí" required> Sí
                                                <input type="radio" name="RFC_VERIFICACION" value="No"> No
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-end">Precios</label>
                                            <div class="ms-3">
                                                <input type="radio" name="PRECIOS_VERIFICACION" value="Sí" required> Sí
                                                <input type="radio" name="PRECIOS_VERIFICACION" value="No"> No
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-end">Moneda</label>
                                            <div class="ms-3">
                                                <input type="radio" name="MONEDA_VERIFICACION" value="Sí" required> Sí
                                                <input type="radio" name="MONEDA_VERIFICACION" value="No"> No
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-end">Servicio</label>
                                            <div class="ms-3">
                                                <input type="radio" name="SERVICIO_VERIFICACION" value="Sí" required> Sí
                                                <input type="radio" name="SERVICIO_VERIFICACION" value="No"> No
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-end">Días de Crédito</label>
                                            <div class="ms-3">
                                                <input type="radio" name="DIAS_CREDITO_VERIFICACION" value="Sí" required> Sí
                                                <input type="radio" name="DIAS_CREDITO_VERIFICACION" value="No"> No
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-end">Cantidad</label>
                                            <div class="ms-3">
                                                <input type="radio" name="CANTIDAD_VERIFICACION" value="Sí" required> Sí
                                                <input type="radio" name="CANTIDAD_VERIFICACION" value="No"> No
                                            </div>
                                        </div>
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