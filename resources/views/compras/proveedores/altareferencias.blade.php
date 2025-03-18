@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-journal-text"></i>&nbsp;Referencia comerciales</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_referencia" style="margin-left: auto;">
            Nueva &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablacategoria" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_referencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCertificaciones" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva referencia comercial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Nombre de la empresa *</label>
                                    <input type="text" class="form-control" name="NOMBRE_EMPRESA" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Nombre del contacto *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CARGO" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CARGO" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Teléfono *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CARGO" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Correo electrónico *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CARGO" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Producto y/o servicio suministrado *</label>
                                    <input type="text" class="form-control" name="PRODUCTO_SERVICIO" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="DESDE" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Hasta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="HASTA" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormcategorias">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection