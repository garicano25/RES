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


@endsection