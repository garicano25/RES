@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Nueva vacante</h3>


        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_jerarquia" data-bs-toggle="modal" data-bs-target="#miModal_FUNCIONESGESTION" style="margin-left: auto;">
            Nueva  &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablafuncionesgestion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_FUNCIONESGESTION" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioFUNCIONESGESTION" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva vacante</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select name="categoria" id="categoria" class="form-select">
                            <option value="" selected disabled>Seleccionar categoría</option>
                            <!-- Opciones de categorías aquí -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de la vacante</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="8" placeholder="Escribe la descripción de la vacante aquí"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="requisitos" class="form-label">Requerimientos de la vacante</label>
                        <textarea name="requisitos" id="requisitos" class="form-control" rows="4" placeholder="Escribe los Requerimientos de la vacante aquí"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormFuncionesgestion">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    

@endsection