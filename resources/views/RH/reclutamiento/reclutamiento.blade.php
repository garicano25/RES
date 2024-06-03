@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5 text-center" style="display: flex; justify-content: center; align-items: center; background-color: transparent;">
        <h3 style="color: #ffffff; margin: 0; display: flex; align-items: center;">
            <i class="bi bi-person-lines-fill" style="margin-right: 0.5rem;"></i> Listado Vacantes
        </h3>
    </ol>
    

    <div class="card-body">
        <table id="Tablafuncionesgestion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>



@endsection