@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-pdf-fill"></i>&nbsp;Documentos de soporte</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_cuentas" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tabladocumentosproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_cuentas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCuentas" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva cuenta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de cuenta *</label>
                                    <select class="form-control" name="TIPO_CUENTA" id="TIPO_CUENTA" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Ahorros">Ahorros</option>
                                        <option value="Cheques">Cheques</option>
                                        <option value="Extranjera">Extranjera</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre del beneficiario *</label>
                                    <input type="text" class="form-control" name="NOMBRE_BENEFICIARIO" id="NOMBRE_BENEFICIARIO" required>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCuentas">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection