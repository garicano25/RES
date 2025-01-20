@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-pencil-fill"></i>&nbsp;Solicitudes</h3>

    <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_AREAINTERES" style="margin-left: auto;">
        Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
    </button>

  </ol>

  <div class="card-body">
    <table id="Tablasolicitudes" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
</div>


</div>











<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/th





  @endsection