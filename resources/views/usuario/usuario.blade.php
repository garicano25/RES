@extends('principal.maestra')

@section('contenido')



<style type="text/css" media="screen">
/* Estilos personalizados para Dropify */
/* Estilos personalizados para Dropify */
.dropify-wrapper {
    height: 270px !important; /* Ajuste de altura */
    border-radius: 5px; /* Borde redondeado */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Sombra */
    text-align: center; /* Centrar el contenido */
}

.dropify-message p {
    font-size: 14px; /* Tamaño de fuente del mensaje */
    margin: 0; /* Quitar márgenes */
}


/* Otros ajustes de estilo para el modal */
.modal-header .close {
    font-size: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
}

.btn-default.waves-effect {
    background-color: #f1f1f1;
    border: 1px solid #ddd;
}

.btn-danger {
    background-color: #d9534f;
    border-color: #d43f3a;
}

.form-control {
    margin-bottom: 15px;
}

</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-fill"></i>&nbsp;Usuarios </h3>
        <button type="button" class="btn btn-light waves-effect waves-light" id="btnNuevoUsuario" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>
    <div class="card-body">
        <table id="Tablausuarios" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <!-- Contenido de la tabla -->
        </table>
    </div>
</div>








<div class="modal fade" id="modal_usuario" tabindex="-1" aria-labelledby="EXAMPLEMODALLABEL" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width: 1100px!important;">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioUSUARIO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EXAMPLEMODALLABEL">Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        {!! csrf_field() !!}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Tipo *</label>
                                                <select class="form-select" id="USUARIO_TIPO" name="USUARIO_TIPO" required>
                                                    <option value="0" disabled selected>Seleccione una opción</option>
                                                    <option value="1">Usuario empleado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 campo_dato_empleado">
                                            <div class="form-group">
                                                <label>Nombre (s) *</label>
                                                <input type="text" class="form-control" id="EMPLEADO_NOMBRE" name="EMPLEADO_NOMBRE" required>
                                            </div>
                                        </div>
                                        <div class="col-12 campo_dato_empleado">
                                            <div class="form-group">
                                                <label>Apellido paterno *</label>
                                                <input type="text" class="form-control" id="EMPLEADO_APELLIDOPATERNO" name="EMPLEADO_APELLIDOPATERNO" required>
                                            </div>
                                        </div>
                                        <div class="col-12 campo_dato_empleado">
                                            <div class="form-group">
                                                <label>Apellido materno *</label>
                                                <input type="text" class="form-control" id="EMPLEADO_APELLIDOMATERNO" name="EMPLEADO_APELLIDOMATERNO" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label id="FOTO_TITULO">Foto usuario *</label>
                                        <style>
                                            .dropify-wrapper {
                                                height: 270px !important;
                                                border-radius: 5px;
                                                box-shadow: 0 0 5px rgba(0,0,0,0.1);
                                                text-align: center;
                                            }
                                            .dropify-message p {
                                                font-size: 14px;
                                                margin: 0;
                                            }
                                        </style>
                                        <input type="file" accept="image/jpeg,image/x-png" id="FOTO_USUARIO" name="FOTO_USUARIO" class="dropify" data-allowed-file-extensions="jpg png" data-height="300" data-default-file=""  />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 campo_dato_empleado">
                                    <div class="form-group">
                                        <label>Dirección *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_DIRECCION" name="EMPLEADO_DIRECCION" required>
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado">
                                    <div class="form-group">
                                        <label>Cargo *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_CARGO" name="EMPLEADO_CARGO" required>
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado">
                                    <div class="form-group">
                                        <label>Teléfono *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_TELEFONO" name="EMPLEADO_TELEFONO" required>
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado">
                                    <div class="form-group">
                                        <label>Fecha de nacimiento *</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="EMPLEADO_FECHANACIMIENTO" name="EMPLEADO_FECHANACIMIENTO" required>
                                            <span class="input-group-addon"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado">
                                    <div class="form-group">
                                        <label>Correo de acceso *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_CORREO" name="EMPLEADO_CORREO" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>Contraseña *</label>
                                        <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" required>
                                    </div>
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-link p-0 toggle-password" data-toggle="#PASSWORD" style="font-size: 1.5em;">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>Confirmar Contraseña *</label>
                                        <input type="password" class="form-control" id="PASSWORD_2" name="PASSWORD_2" required>
                                    </div>
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-link p-0 toggle-password" data-toggle="#PASSWORD_2" style="font-size: 1.5em;">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <span id="PASSWORD_MENSAJE" style="display: none; color: red; font-weight: bold;"></span>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormUSUARIO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>














<!-- ============================================================== -->
<!-- MODAL-USUARIO -->
<!-- ============================================================== -->





@endsection