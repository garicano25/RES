@extends('principal.maestralmacen')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-box-arrow-right"></i>&nbsp;Salida de almacén de materiales y/o equipos</h3>

    </ol>

    <div class="card-body">
        <table id="Tablasalidalmacen" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>




<div class="modal fade" id="miModal_RECURSOSEMPLEADOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRECURSOSEMPLEADO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Salida de almacén de materiales y/o equipos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}



                    <div class="col-12 mb-3">
                        <label class="form-label">Seleccione el tipo *</label>
                        <select class="form-control" id="TIPO_SOLICITUD" name="TIPO_SOLICITUD" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Aviso de ausencia y/o permiso</option>
                            <option value="2">Salida de almacén de materiales y/o equipos</option>
                            <!-- <option value="3">Solicitud de Vacaciones</option> -->
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label">Solicitante </label>
                                <input type="text" class="form-control" value="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}" id="SOLICITANTE_SALIDA" name="SOLICITANTE_SALIDA" readonly>
                            </div>

                            <div class="col-3">
                                <label class="form-label">Fecha de solicitud *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SALIDA" name="FECHA_SALIDA" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="SOLIDA_ALMACEN" style="display: none;">


                        <div class="mt-3">
                            <div class="materialesdiv mt-4"></div>
                        </div>


                        <div class="col-12 mt-3 d-flex align-items-center">
                            <div class="col-6" id="FECHA_ESTIMADA" style="display: none;">
                                <label class="col-form-label me-2">Fecha estimada de retorno *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd"
                                        id="FECHA_ESTIMADA_SALIDA" name="FECHA_ESTIMADA_SALIDA">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="mt-3">
                        <label>Observaciones *</label>
                        <textarea class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" rows="3" required></textarea>
                    </div>


                    <div class="mt-3">
                        <label class="form-label">Firmado por</label>
                        <input type="text" id="FIRMADO_POR" name="FIRMADO_POR" class="form-control" readonly required>
                    </div>



                    <div id="APROBACION_DIRECCION" style="display: block;">
                        <div class="col-12 mt-3">
                            <label for="ESTADO_APROBACION">Estado de Aprobación</label>
                            <div id="estado-container" class="p-2 rounded">
                                <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Aprobada">Aprobada</option>
                                    <option value="Rechazada">Rechazada</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-3" id="motivo-rechazo-container" style="display: none;">
                            <label>Motivo del rechazo del que aprobo</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">

                                <div class="col-8">
                                    <label for="APROBACION">Quien aprueba</label>
                                    <input type="text" class="form-control" id="QUIEN_APROBACION" name="QUIEN_APROBACION" readonly>
                                </div>
                                <div class="col-4">
                                    <label>Fecha *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APRUEBA_SOLICITUD" name="FECHA_APRUEBA_SOLICITUD">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="col-12 mt-3">
                        <div class="row">

                            <div class="col-8">
                                <label for="APROBACION">Firma almacenista</label>
                                <input type="text" class="form-control" id="FIRMA_ALMACEN" name="FIRMA_ALMACEN" readonly>
                            </div>
                            <div class="col-4">
                                <label>Fecha *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ALMACEN_SOLICITUD" name="FECHA_ALMACEN_SOLICITUD">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-12 mt-3" id="DIV_FIRMAR_ALMACEN" style="display:none; margin-top:10px;">
                        <div class="row justify-content-center">
                            <div class="col-6 text-center">
                                <button type="button"
                                    id="FIRMAR_SOLICITUD_ALMACEN"
                                    class="btn btn-info"
                                    data-usuario="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                    <i class="bi bi-pen-fill"></i> Firma almacenista
                                </button>
                            </div>
                        </div>
                    </div>



                    <input type="hidden" id="FIRMO_ALMACENISTA" name="FIRMO_ALMACENISTA" value="">


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardaRECEMPLEADOS" style="display: block;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection