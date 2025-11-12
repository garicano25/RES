@extends('principal.maestralmacen')

@section('contenido')


<style>
    .bg-amarillo-suave {
        background-color: #fff3cd !important;
    }

    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-card-list"></i>&nbsp;Bitácora de consumibles</h3>

    </ol>

    <div class="card-body">
        <table id="Tablabitacoraconsumibles" class="table table-hover table-bordered text-center w-100 TableCustom">

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


                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label">Solicitante </label>
                                <input type="text" class="form-control" id="SOLICITANTE_SALIDA" name="SOLICITANTE_SALIDA" readonly>
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

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-3 mt-2">
                                <label class="form-label">Descripción del Artículo </label>
                                <input type="text" class="form-control" id="DESCRIPCION" name="DESCRIPCION" readonly>
                            </div>
                            <div class="col-3 mt-2">
                                <label class="form-label">Cantidad solicitada </label>
                                <input type="text" class="form-control" id="CANTIDAD" name="CANTIDAD" readonly>
                            </div>
                            <div class="col-3 mt-2">
                                <label class="form-label">Cantidad que sale del inventario </label>
                                <input type="text" class="form-control" id="CANTIDAD_SALIDA" name="CANTIDAD_SALIDA" readonly>
                            </div>
                            <div class="col-3 mt-2">
                                <label class="form-label">Artículo que sale del inventario </label>
                                <select class="form-select " id="INVENTARIO" name="INVENTARIO" style="pointer-events:none; background-color:#e9ecef;">
                                    <option value="">Seleccione un artículo</option>
                                    @foreach($inventario as $item)
                                    <option value="{{ $item->ID_FORMULARIO_INVENTARIO }}">
                                        {{ $item->DESCRIPCION_EQUIPO }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-4 mt-2">
                                <label class="form-label">Funcionamiento </label>
                                <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1">Buen estado</option>
                                    <option value="2">Mal estado</option>
                                </select>
                            </div>
                            <div class="col-8 mt-2">
                                <label class="form-label">Motivo </label>
                                <input type="text" class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" readonly>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label">Recibido por </label>
                                <input type="text" class="form-control" id="RECIBIDO_POR" name="RECIBIDO_POR" readonly>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label">Firma </label>
                                <input type="text" class="form-control" id="FIRMA_POR" name="FIRMA_POR">
                            </div>


                            <div class="col-12 mt-2">
                                <label class="form-label">Entregado por </label>
                                <input type="text" class="form-control" id="ENTREGADO_POR" name="ENTREGADO_POR">
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label">Firma </label>
                                <input type="text" class="form-control" id="ENTREGADO_POR" name="ENTREGADO_POR">
                            </div>


                            <div class="col-12 mt-2">
                                <label class="form-label">Observación </label>
                                <textarea class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" rows="3" required></textarea>
                            </div>


                        </div>
                    </div>








                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardaRECEMPLEADOS" style="display: block;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    window.tipoinventario = @json($tipoinventario);
    window.inventario = @json($inventario);
</script>





@endsection