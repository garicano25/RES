@extends('principal.maestracompras')

@section('contenido')

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Orden de compra</h3>

    </ol>

    <div class="card-body">
        <table id="Tablaordencompra" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>





<div class="modal modal-fullscreen fade" id="miModal_PO" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioPO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="miModalLabel">Orden de compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <div class="col-12">
                            <div class="row">

                                <div class="col-4 mb-3">
                                    <label class="form-label">N° PO </label>
                                    <input type="text" class="form-control" id="NO_PO" name="NO_PO">
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">N° MR</label>
                                    <input type="text" class="form-control" id="NO_MR" name="NO_MR">
                                </div>

                                <div class="col-4 mb-3">
                                    <label class="form-label">Proveedor seleccionado</label>
                                    <input type="text" class="form-control" id="PROVEEDOR_SELECCIONADO" name="PROVEEDOR_SELECCIONADO" readonly>
                                </div>

                            </div>

                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-productos-body"></tbody>
                        </table>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Subtotal</label>
                                <input type="text" readonly class="form-control text-end" id="SUBTOTAL" name="SUBTOTAL">
                            </div>
                            <div class="col-md-4">
                                <label>IVA (16%)</label>
                                <input type="text" readonly class="form-control text-end" id="IVA" name="IVA">
                            </div>
                            <div class="col-md-4">
                                <label>Importe Total</label>
                                <input type="text" readonly class="form-control text-end" id="IMPORTE" name="IMPORTE">
                            </div>
    
                        </div>









                    </div>

                    <div class="modal-footer mx-5">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="guardarPO">Guardar</button>


                    </div>
            </form>
        </div>
    </div>
</div>



@endsection