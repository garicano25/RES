@extends('principal.maestracompras')

@section('contenido')

<style>
    #Tablabitacora {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #Tablabitacora th,
    #Tablabitacora td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
        /* 👈 centrado global */
        vertical-align: middle;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Bitácora de consecutivos MR</h3>
    </ol>



    <div class="card-body">

        <div class="table-responsive" style="overflow-x: auto;">
            <table id="Tablabitacora" class="table table-hover table-bordered text-center w-100" style="min-width: 3000px; table-layout: fixed;">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Visualizar</th>
                        <th class="text-center">Requisición No.</th>
                        <th class="text-center">Fecha de Solicitud</th>
                        <th class="text-center">Solicitante</th>
                        <th class="text-center">Área Solicitante</th>
                        <th class="text-center">Fecha de Vo. Bo.</th>
                        <th class="text-center">Vo. Bo.</th>
                        <th class="text-center">Fecha Aprobación</th>
                        <th class="text-center">Aprobación</th>
                        <th class="text-center">Prioridad</th>
                        <th class="text-center">Concepto</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Comentario</th>
                        <th class="text-center">Requiere PO</th>
                        <th class="text-center">Fecha de Adquisición</th>
                        <th class="text-center">Proveedor</th>
                        <th class="text-center">Forma de Pago</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>


    </div>

</div>

<!-- Contenedor con scroll horizontal si la tabla es muy ancha -->







<div class="modal fade" id="miModal_MR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioMR" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Requisición de Materiales</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div id="SOLICITUD_MR">


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label>Solicitante </label>
                                    <input type="text" class="form-control id=" SOLICITANTE_MR" name="SOLICITANTE_MR" readonly>
                                </div>

                                <div class="col-3">
                                    <label>Fecha de solicitud *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SOLICITUD_MR" name="FECHA_SOLICITUD_MR" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label>Área Solicitante </label>
                                    <input type="text" class="form-control" id="AREA_SOLICITANTE_MR" name="AREA_SOLICITANTE_MR" readonly>
                                </div>
                                <div class="col-3">
                                    <label>No. de MR *</label>
                                    <input type="text" class="form-control" id="NO_MR" name="NO_MR" readonly>
                                </div>
                            </div>
                        </div>



                        <div class="mt-3">
                            <div class="row">
                                <!-- <div class="col-6 mb-3">
                                    <label>Agregar material</label>
                                    <button id="botonmaterial" id="botonmaterial" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="materialesdiv mt-4"></div>
                        </div>

                        <div class="mt-3">
                            <label>Justificación *</label>
                            <textarea class="form-control" id="JUSTIFICACION_MR" name="JUSTIFICACION_MR" rows="3"></textarea>
                        </div>





                        <div id="VISTO_BUENO_JEFE" style="display: block;">



                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="PRIORIDAD">Prioridad</label>
                                        <select class="form-control" id="PRIORIDAD_MR" name="PRIORIDAD_MR">
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="Alta">Alta 1-15 días</option>
                                            <option value="Media">Media 16-30 días</option>
                                            <option value="Baja">Baja 31-60 días</option>
                                        </select>
                                    </div>

                                    <div class="col-8">
                                        <label for="OBSERVACIONES">Observaciones</label>
                                        <input type="text" class="form-control" id="OBSERVACIONES_MR" name="OBSERVACIONES_MR">
                                    </div>
                                </div>
                            </div>





                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-8">
                                        <label for="VISTO_BUENO">Visto bueno</label>
                                        <input type="text" class="form-control" id="VISTO_BUENO" name="VISTO_BUENO">
                                    </div>

                                    <div class="col-4">
                                        <label>Fecha *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VISTO_MR" name="FECHA_VISTO_MR">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 mt-3" id="MOTIVO_RECHAZO_JEFE_DIV" style="display: none;">
                                <label>Motivo del rechazo del jefe inmediato</label>
                                <textarea class="form-control" id="MOTIVO_RECHAZO_JEFE" name="MOTIVO_RECHAZO_JEFE" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                            </div>


                        </div>


                        <div id="BOTON_VISTO_BUENO" style="display: none;">
                            <div id="solicitarVerificacionDiv" class="col-12 text-center mt-3" style="display: block;">

                                <input type="hidden" id="DAR_BUENO" name="DAR_BUENO" value="0">
                            </div>



                        </div>




                        <div id="APROBACION_DIRECCION" style="display: none;">


                            <div class="col-12 mt-3">
                                <label for="ESTADO_APROBACION">Estado de Aprobación</label>
                                <div id="estado-container" class="p-2 rounded">
                                    <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION" onchange="cambiarColor()">
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
                                        <input type="text" class="form-control" id="QUIEN_APROBACION" name="QUIEN_APROBACION">

                                        <meta name="usuario-autenticado" content="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                    </div>
                                    <div class="col-4">
                                        <label>Fecha *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APRUEBA_MR" name="FECHA_APRUEBA_MR">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>




                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
            </form>
        </div>
    </div>
</div>



@endsection