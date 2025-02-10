@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-patch-check-fill"></i>&nbsp;Orden de trabajo </h3>

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
                    <h5 class="modal-title" id="miModalLabel">Orden de trabajo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">







                        <div class="col-12 mt-3">
                            <div class="row">
                           

                                <div class="col-6">
                                    <label>Orden de Trabajo (OT) No. </label>
                                    <input type="text" class="form-control" id="NO_ORDEN_CONFIRMACION" name="NO_ORDEN_CONFIRMACION">
                                </div>

                                <div class="col-6">
                                    <label>Fecha de emisión de la OT*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO_CONFIRMACION" name="FECHA_INICIO_CONFIRMACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12 mt-3">
                            <div class="row">

                                <div class="col-3">
                                    <label>Verificado por  </label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}" readonly>
                                </div>

                                <div class="col-3">
                                    <label>Fecha de verificación *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VERIFICACION_CONFIRMACION" name="FECHA_VERIFICACION_CONFIRMACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label>Prioridad del servicio *</label>
                                    <select class="form-control" id="PRIORIDAD_CONFIRMACION" name="PRIORIDAD_CONFIRMACION" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">Normal</option>
                                        <option value="2">Urgente</option>
                                    </select>
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