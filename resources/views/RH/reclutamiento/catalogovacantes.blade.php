@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Nueva vacante</h3>


        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_jerarquia" data-bs-toggle="modal" data-bs-target="#miModal_vacantes" style="margin-left: auto;">
            Nueva &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>
    <div class="card-body">
        <table id="Tablavacantes" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
    </div>
</div>



<div class="modal fade" id="miModal_vacantes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioVACANTES" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva vacante</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}



                    <div class="mb-3">
                        <label>La vacante es: *</label>
                        <select class="form-select" id="LA_VACANTES_ES" name="LA_VACANTES_ES" required>
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="Pública">Pública</option>
                            <option value="Privada">Privada</option>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label>Categoría</label>
                        <select class="form-control" id="CATEGORIA_VACANTE" name="CATEGORIA_VACANTE" required>
                            <option selected disabled>Seleccione una opción</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->NOMBRE_CATEGORIA }}">{{ $area->NOMBRE_CATEGORIA }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Descripción de la vacante</label>
                        <textarea name="DESCRIPCION_VACANTE" id="DESCRIPCION_VACANTE" class="form-control" rows="8" placeholder="Escribe la descripción de la vacante aquí"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Lugar de la vacante</label>
                        <input  type="text" name="LUGAR_VACANTE" id="LUGAR_VACANTE" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Fecha de expiración de la vacante</label>
                        <input type="date" name="FECHA_EXPIRACION" id="FECHA_EXPIRACION"  class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Requerimiento de Vacantes:</label>
                        <button id="botonAgregar" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar requerimiento"><i class="bi bi-plus-circle-fill"></i></button>
                        <div id="inputs-container" class="mt-3"></div>
                    </div>
                    

                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormvacantes">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection