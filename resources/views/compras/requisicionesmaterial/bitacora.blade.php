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
        vertical-align: middle;
    }


    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }

    .bg-rojo-suave {
        background-color: #f8d7da !important;
    }

    .color-vo {
        transition: background-color 0.3s ease;
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
                        <th class="text-center">Hoja</th>
                        <th class="text-center">Requisición No.</th>
                        <th class="text-center">Fecha de Solicitud</th>
                        <th class="text-center">Solicitante</th>
                        <th class="text-center">Área Solicitante</th>
                        <th class="text-center">Fecha de Vo. Bo.</th>
                        <th class="text-center">Vo. Bo.</th>
                        <th class="text-center">Fecha Aprobación</th>
                        <th class="text-center">Aprobación</th>
                        <th class="text-center">Prioridad</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Comentario</th>

                        <th class="text-center">Fecha de Adquisición</th>

                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>


    </div>

</div>

<!-- Contenedor con scroll horizontal si la tabla es muy ancha -->




<!-- <div class="modal fade" id="modalMateriales" tabindex="-1" aria-labelledby="tituloMateriales" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="background-color: #ffffff;">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloMateriales">Materiales Aprobados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <ul id="listaMateriales" class="list-group"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> -->



<!-- Modal para visualizar materiales con hoja de trabajo -->
<div class="modal fade" id="modalMateriales" tabindex="-1" aria-labelledby="tituloMateriales" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tituloMateriales">Hoja de Trabajo - Materiales Aprobados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Contenedor de tarjetas de productos -->
                <div id="contenedorProductos"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnGuardarTodo">Guardar Todo</button>
            </div>
        </div>
    </div>
</div>

<!-- Template para cada producto -->
<template id="templateProducto">
    <div class="card mb-4 producto-card">
        <div class="card-header bg-light">
            <h5 class="producto-titulo mb-0"></h5>
        </div>
        <div class="card-body">
            <!-- Sección de cotizaciones -->
            <h6 class="fw-bold">Cotizaciones</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>Cotización</th>
                            <th>Documento</th>
                            <th>Proveedor</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fila-cotizacion" data-cotizacion="Q1">
                            <td>Q1</td>
                            <td>
                                <div class="input-group">
                                    <input type="file" class="form-control doc-cotizacion" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                    <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                </div>
                            </td>
                            <td>
                                <select class="form-select proveedor-cotizacion">
                                    <option value="">Seleccionar proveedor</option>
                                    <option value="Proveedor 1">Proveedor 1</option>
                                    <option value="Proveedor 2">Proveedor 2</option>
                                    <option value="Proveedor 3">Proveedor 3</option>
                                    <option value="Otro">Otro proveedor</option>
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control importe-cotizacion" step="0.01" min="0">
                                </div>
                            </td>
                        </tr>
                        <tr class="fila-cotizacion" data-cotizacion="Q2">
                            <td>Q2</td>
                            <td>
                                <div class="input-group">
                                    <input type="file" class="form-control doc-cotizacion" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                    <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                </div>
                            </td>
                            <td>
                                <select class="form-select proveedor-cotizacion">
                                    <option value="">Seleccionar proveedor</option>
                                    <option value="Proveedor 1">Proveedor 1</option>
                                    <option value="Proveedor 2">Proveedor 2</option>
                                    <option value="Proveedor 3">Proveedor 3</option>
                                    <option value="Otro">Otro proveedor</option>
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control importe-cotizacion" step="0.01" min="0">
                                </div>
                            </td>
                        </tr>
                        <tr class="fila-cotizacion" data-cotizacion="Q3">
                            <td>Q3</td>
                            <td>
                                <div class="input-group">
                                    <input type="file" class="form-control doc-cotizacion" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                    <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                </div>
                            </td>
                            <td>
                                <select class="form-select proveedor-cotizacion">
                                    <option value="">Seleccionar proveedor</option>
                                    <option value="Proveedor 1">Proveedor 1</option>
                                    <option value="Proveedor 2">Proveedor 2</option>
                                    <option value="Proveedor 3">Proveedor 3</option>
                                    <option value="Otro">Otro proveedor</option>
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control importe-cotizacion" step="0.01" min="0">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Sección de selección final -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Proveedor seleccionado:</label>
                        <select class="form-select proveedor-seleccionado">
                            <option value="">Seleccionar proveedor final</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">¿Requiere PO?</label>
                        <div class="form-check">
                            <input class="form-check-input requiere-po" type="radio" name="requierePO" value="si">
                            <label class="form-check-label">Sí</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input requiere-po" type="radio" name="requierePO" value="no" checked>
                            <label class="form-check-label">No</label>
                        </div>
                    </div>

                    <div class="mb-3 campo-monto-final d-none">
                        <label class="form-label fw-bold">Monto final:</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control monto-final" step="0.01" min="0">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Forma de pago:</label>
                        <select class="form-select forma-pago">
                            <option value="">Seleccionar forma de pago</option>
                           
                        </select>
                    </div>

                    <div class="alert alert-warning matriz-comparativa d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Aviso:</strong> Se requiere realizar una Matriz comparativa de cotizaciones
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>




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
                                    <input type="text" class="form-control" id="SOLICITANTE_MR" name="SOLICITANTE_MR" readonly>
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