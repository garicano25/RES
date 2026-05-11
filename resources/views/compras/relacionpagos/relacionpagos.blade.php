@extends('principal.maestracompras')

@section('contenido')

<div class="contenedor-contenido">
    <ol class="breadcrumb mt-2" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">
            <i class="bi bi-cash-stack"></i>&nbsp;&nbsp;Relación de pagos
        </h3>
        <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_RELACION"  style="margin-left: auto;">
            Nueva &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablarelacionpagos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>




<div class="modal fade" id="modalRelacionPagos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRELACION" style="background-color: #ffffff;">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-box-seam"></i> Relación de pagos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}










                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarRELACION">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection