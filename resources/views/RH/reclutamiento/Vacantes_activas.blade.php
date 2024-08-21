@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3  style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Vacantes activas</h3>

    </ol>

    
    <div class="card-body">
        <table id="Tablapostulaciones" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
    </div>
</div>





<!-- Modal Full Screen -->
<div class="modal fade" id="modalFullScreen" tabindex="-1" aria-labelledby="modalFullScreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFullScreenLabel">Detalles de Postulantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se insertará el contenido dinámico -->
                <div id="modalContent"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>


        </div>
    </div>
</div>


&nbsp;


@endsection