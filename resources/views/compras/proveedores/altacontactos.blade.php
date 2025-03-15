@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Contactos</h3>

   
        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_contactos" style="margin-left: auto;">
            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablacategoria" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_contactos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCertificaciones" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo contacto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" name="CONTACTO_SOLICITUD" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="CARGO_SOLICITUD" required>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" name="TELEFONO_SOLICITUD">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Extensión</label>
                                    <input type="text" class="form-control" name="EXTENSION_SOLICITUD">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Celular *</label>
                                    <input type="text" class="form-control" name="CELULAR_SOLICITUD" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Correo electrónico *</label>
                                    <input type="email" class="form-control" name="CORREO_SOLICITUD" required>
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