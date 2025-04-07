@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-pdf-fill"></i>&nbsp;Documentos de soporte</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_documentos" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tabladocumentosproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_documentos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDOCUMENTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo documento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Documento *</label>
                            <select class="form-control" name="NOMBRE_DOCUMENTO" id="NOMBRE_DOCUMENTO" required>
                                <option value="" selected disabled>Seleccione una opción</option>

                                @foreach ($documetoscatalogo as $documento)
                                <option value="{{ $documento->NOMBRE_DOCUMENTO }}">
                                    {{ $documento->NOMBRE_DOCUMENTO }}
                                </option>
                                @endforeach
                            </select>
                        </div>




                        <div class="col-12 mb-3">
                            <label class="form-label">
                                Anexar documento &nbsp;
                            </label>
                            <div class="input-group align-items-center">
                                <input type="file" class="form-control" name="DOCUMENTO_SOPORTE" id="DOCUMENTO_SOPORTE" accept="application/pdf">
                                <i id="iconEliminarArchivo" class="bi bi-trash-fill ms-2 text-danger fs-5 d-none" style="cursor: pointer;" title="Eliminar archivo"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTOS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection