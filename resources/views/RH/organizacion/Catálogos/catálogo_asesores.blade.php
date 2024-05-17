@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-people-fill"></i>&nbsp;Asesores</h3>


        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_jerarquia" data-bs-toggle="modal" data-bs-target="#miModal_JERARQUIA" style="margin-left: auto;">
            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablajerarquia" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>
















@endsection