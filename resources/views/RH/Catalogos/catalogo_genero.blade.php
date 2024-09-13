@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Género</h3>
        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_asesores" data-bs-toggle="modal" data-bs-target="#miModal_Genero" style="margin-left: auto;">
            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablageneros" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>



<div class="modal fade" id="miModal_Genero" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post"  enctype="multipart/form-data" id="formularioGenero" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar género</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label>Nombre del Género *</label>
                        <input type="text" class="form-control" id="NOMBRE_GENERO" name="NOMBRE_GENERO" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción </label>
                        <textarea class="form-control" id="DESCRIPCION_GENERO" name="DESCRIPCION_GENERO" rows="8"></textarea>
                    </div>
                     
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormGENERO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection