@extends('pagina_web.maestrapagina')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0; text-align: center;">&nbsp;Mensajes</h3>
    </ol>

    <div class="card-body">
        <table id="Tablamensajepaginaweb" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>



<div class="modal fade" id="miModal_MENSAJES" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioMENSAJES" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="NOMBRE" name="NOMBRE">
                    </div>

                    <div class="mb-3">
                        <label>Correo electrónico </label>
                        <input type="text" class="form-control" id="CORREO" name="CORREO">
                    </div>

                    <div class="mb-3">
                        <label>Número de teléfono </label>
                        <input type="text" class="form-control" id="TELEFONO" name="TELEFONO">
                    </div>

                    <div class="mb-3">
                        <label>Mensaje: *</label>
                        <textarea class="form-control" id="MENSAJE" name="MENSAJE" rows="5"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection