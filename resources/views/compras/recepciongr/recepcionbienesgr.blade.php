@extends('principal.maestracompras')

@section('contenido')

<style>
    .tabla-scroll-wrapper {
        width: 100%;
    }

    .tabla-scroll-top {
        overflow-x: auto;
        height: 20px;
        background: #f8f9fa;
    }

    .tabla-scroll-top .scroll-inner {
        height: 1px;
        background: transparent;
    }

    .tabla-scroll-bottom {
        overflow-x: auto;
        margin-top: 5px;
    }


    /* ========== TABLA BITÁCORA GENERAL ========== */
    #Tablabitacoragr {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #Tablabitacoragr th,
    #Tablabitacoragr td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
        vertical-align: middle;
    }

    /* ========== EXCEPCIÓN: COLUMNA JUSTIFICACIÓN ========== */
    #Tablabitacoragr td.col-justificacion {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
        word-wrap: break-word !important;
        text-align: center !important;
        vertical-align: middle !important;
        height: auto !important;
        line-height: 1.3em;
    }

    /* ========== TABLA COTIZACIONES (si aplica) ========== */
    #tablaCotizaciones {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #tablaCotizaciones th,
    #tablaCotizaciones td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
        vertical-align: middle;
    }




    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }

    .bg-rojo-suave {
        background-color: #f8d7da !important;
    }

    .color-vo {
        transition: background-color 0.3s ease;
    }


    .bloquear-interaccion {
        position: relative;
    }

    .bloquear-interaccion::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        background: transparent;
        pointer-events: all;
        /* esto bloquea todo */
    }


    /* .input-bloqueado {
        pointer-events: none;
        background-color: #e9ecef;
        cursor: not-allowed;
    } */



    .select-finalizada {
        background-color: #d4edda !important;
        color: #155724 !important;
        font-weight: bold;
    }

    .select-en-proceso {
        background-color: #fff3cd !important;
        color: #856404 !important;
        font-weight: bold;
    }

    .select-sin-datos {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        font-weight: bold;
    }
</style>

<div class="contenedor-contenido">

    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Bitácora de consecutivos MR</h3>
    </ol>


    <div class="card-body">




        <div class="tabla-scroll-wrapper">
            <div class="tabla-scroll-top">
                <div class="scroll-inner"></div>
            </div>
            <div class="tabla-scroll-bottom">
                <div class="table-responsive">
                    <table id="Tablabitacoragr" class="table table-hover table-bordered text-center w-100" style="min-width: 3000px; table-layout: fixed;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No.MR</th>
                                <th class="text-center">Fecha de aprobación.MR</th>
                                <th class="text-center">No.PO</th>
                                <th class="text-center">Fecha de aprobación.PO</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Fecha de entrega.PO</th>
                                <th class="text-center">Bien o servicio</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>

</div>







<!-- Template para cada producto -->















@endsection