@extends('principal.maestraventas')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Giro de la empresa
        </h3>


        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_GIROEMPRESA" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablagiroempresa" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_GIROEMPRESA" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioGIROEMPRESA" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Giro de la empresa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                
                    <div class="mb-3">
                        <label>Nombre *</label>
                        <textarea class="form-control" id="NOMBRE_GIRO" name="NOMBRE_GIRO" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarGIROEMPRESA">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection