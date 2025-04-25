@extends('principal.maestra')

@section('contenido')

<style>
    <style>.fila-brecha {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        border-bottom: 1px solid #eee;
    }

    .mensaje-brecha {
        flex: 1;
        padding-right: 10px;
        text-align: left;
        font-size: 14px;
    }

    .porcentaje-brecha {
        width: 80px;
        text-align: right;
        font-weight: bold;
        font-size: 14px;
    }
</style>

</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Brecha de competencias</h3>
        <!-- <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_ANUNCIO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button> -->
    </ol>

    <div class="card-body">
        <table id="Tablabrecha" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>









<div class="modal modal-fullscreen fade" id="miModal_BRECHA" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioBRECHA" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <div class="col-12">
                            <div class="row">

                                <div class="col-4 mb-3">
                                    <label class="form-label">CURP </label>
                                    <input type="text" class="form-control" id="CURP" name="CURP" readonly>
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">Nombre del colaborador</label>
                                    <input type="text" class="form-control" id="NOMBRE_BRECHA" name="NOMBRE_BRECHA" readonly>
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">Porcentaje faltante </label>
                                    <input type="text" class="form-control" id="PORCENTAJE_FALTANTE" name="PORCENTAJE_FALTANTE" readonly>
                                </div>

                            </div>
                            <div class="mt-3">
                                <h5>Brechas detectadas:</h5>
                                <div id="listaBrechas"></div>
                                <p id="contadorBrechas" class="fw-bold mt-2"></p>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer mx-5">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="guardarBRECHA">
                            <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar brecha"></i> Guardar
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>





@endsection