@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-briefcase-fill"></i>&nbsp;Actualización de documentos del colaborador</h3>

    </ol>



    <div class="row justify-content-center align-items-end mb-4">
        <div class="col-md-3 text-center">
            <label>Fecha inicio</label>
            <div class="input-group">
                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO">
                <span class="input-group-text">
                    <i class="bi bi-calendar-event"></i>
                </span>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <label>Fecha fin</label>
            <div class="input-group">
                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_FIN">
                <span class="input-group-text">
                    <i class="bi bi-calendar-event"></i>
                </span>
            </div>
        </div>
        <div class="col-md-2 d-flex">
            <button type="submit" class="btn btn-success " id="guardaractulizacion">Guardar</button>
        </div>
    </div>





</div>











@endsection