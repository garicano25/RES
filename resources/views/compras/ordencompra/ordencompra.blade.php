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

                                <div class="col-6 mb-3">
                                    <label class="form-label">N° PO </label>
                                    <input type="text" class="form-control" id="NO_PO" name="NO_PO" readonly>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">N° MR</label>
                                    <input type="text" class="form-control" id="NO_MR" name="NO_MR" readonly>
                                </div>


                            </div>

                        </div>


                        <div class="form-group mb-3">
                            <label for="proveedor_seleccionado">Proveedor seleccionado</label>
                            <input type="text" class="form-control" id="proveedor_seleccionado" readonly>
                        </div>

                        <table id="tabla_materiales" class="table">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Cantidad real</th>
                                    <th>Precio unitario</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="mt-4">
                            <div class="row mb-2">
                                <div class="col-md-3"><strong>Subtotal:</strong></div>
                                <div class="col-md-3"><input type="text" id="subtotal_q" class="form-control" readonly></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3"><strong>IVA:</strong></div>
                                <div class="col-md-3"><input type="text" id="iva_q" class="form-control" readonly></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3"><strong>Total:</strong></div>
                                <div class="col-md-3"><input type="text" id="importe_q" class="form-control" readonly></div>
                            </div>
                        </div>




                    </div>

                    <div class="modal-footer mx-5">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>

                    </div>
            </form>
        </div>
    </div>
</div>



@endsection