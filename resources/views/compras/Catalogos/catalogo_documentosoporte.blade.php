@extends('principal.maestracompras')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Documentos de soporte</h3>
        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_asesores" data-bs-toggle="modal" data-bs-target="#miModal_documentos" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tabladocumentosoportes" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>



<div class="modal fade" id="miModal_documentos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDOCUMENTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar documentos de soporte</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Tipo de Proveedor *</label>
                        <select class="form-control" name="TIPO_PERSONA" id="TIPO_PERSONA" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Nacional</option>
                            <option value="2">Extranjero</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label>Tipo de Persona *</label>
                        <select class="form-control" name="TIPO_PERSONA_OPCION" id="TIPO_PERSONA_OPCION" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Moral</option>
                            <option value="2">Física</option>
                            <option value="3">Moral y física</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nombre del documento *</label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO" name="NOMBRE_DOCUMENTO" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción </label>
                        <textarea class="form-control" id="DESCRIPCION_DOCUMENTO" name="DESCRIPCION_DOCUMENTO" rows="5"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection