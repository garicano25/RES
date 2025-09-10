@extends('principal.maestralmacen')

@section('contenido')

<style>
    .dropify-wrapper {
        height: 270px !important;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        text-align: center;

    }

    .dropify-message p {
        font-size: 14px;
        margin: 0;
    }


    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }

    .bg-rojo-suave {
        background-color: #f8d7da !important;
    }
</style>


<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5 d-flex justify-content-between align-items-center" style="background:#a7d46f; border-radius:10px; padding:10px;">

        <h3 class="mb-0 text-white">
            <i class="bi bi-card-list me-2"></i> Inventario
        </h3>

        <div class="d-flex gap-2">
            @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador']))
            <button type="button"
                class="btn btn-secondary waves-effect waves-light"
                data-toggle="tooltip"
                title="Cargar equipos por medio de un archivo Excel"
                id="boton_cargarExcelEquipos">
                Importar <i class="bi bi-file-earmark-excel-fill"></i>
            </button>

            <!-- <button id="btnRespaldarInventario" class="btn btn-primary">
                <i class="bi bi-copy"></i> Respaldar Inventario
            </button> -->


            @endif

            <button type="button"
                class="btn btn-light waves-effect waves-light"
                id="NUEVO_EQUIPO">
                Nuevo <i class="bi bi-plus-circle"></i>
            </button>
        </div>
    </ol>

    <div class="card-body">
        <table id="Tablainventario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>







<div id="Modal_inventario" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 86%;">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioINVENTARIO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Equipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="tabsinventario" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-info" data-bs-toggle="tab" data-bs-target="#contenido-info" type="button" role="tab">Información del producto</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-entrada" data-bs-toggle="tab" data-bs-target="#contenido-entrada" type="button" role="tab">Bitácora</button>
                        </li>

                    </ul>


                    <!-- Tab contents -->
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="contenido-info" role="tabpanel">

                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label> Foto del equipo </label>
                                                        <input type="file" accept="image/jpeg,image/x-png,image/gif" id="FOTO_EQUIPO" name="FOTO_EQUIPO" data-allowed-file-extensions="jpg png JPG PNG" data-height="240" data-default-file="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="row">
                                                <div class="col-12">
                                                    {!! csrf_field() !!}
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label> Descripción del equipo*</label>
                                                        <textarea class="form-control" id="DESCRIPCION_EQUIPO" name="DESCRIPCION_EQUIPO" rows="5" required re></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Marca </label>
                                                        <input type="text" class="form-control" id="MARCA_EQUIPO" name="MARCA_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Modelo </label>
                                                        <input type="text" class="form-control" id="MODELO_EQUIPO" name="MODELO_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Serie </label>
                                                        <input type="text" class="form-control" id="SERIE_EQUIPO" name="SERIE_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label>Código de Identificación </label>
                                                        <input type="text" class="form-control" id="CODIGO_EQUIPO" name="CODIGO_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-4 mt-2">
                                                    <div class="form-group">
                                                        <label> Cantidad </label>
                                                        <input type="Number" step="any" class="form-control" id="CANTIDAD_EQUIPO" name="CANTIDAD_EQUIPO">
                                                    </div>
                                                </div>

                                                <div class="col-8 mt-2">
                                                    <div class="form-group">
                                                        <label> Ubicación </label>
                                                        <input type="text" step="any" class="form-control" id="UBICACION_EQUIPO" name="UBICACION_EQUIPO">
                                                    </div>
                                                </div>


                                                <div class="col-6 mt-2">
                                                    <div class="form-group">
                                                        <label> Estado </label>
                                                        <input type="text" step="any" class="form-control" id="ESTADO_EQUIPO" name="ESTADO_EQUIPO">
                                                    </div>
                                                </div>

                                                <div class="col-6 mt-2">
                                                    <div class="form-group">
                                                        <label>Fecha de adquisición </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ADQUISICION" name="FECHA_ADQUISICION">
                                                            <span class="input-group-addon"><i class="icon-calender"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="form-group">
                                                        <label> Nombre del proveedor </label>
                                                        <input type="text" step="any" class="form-control" id="PROVEEDOR_EQUIPO" name="PROVEEDOR_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-4 mt-2">
                                                    <div class="form-group">
                                                        <label> Precio Unitario (MXN)</label>
                                                        <input type="text" step="any" class="form-control" id="UNITARIO_EQUIPO" name="UNITARIO_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-4 mt-2">
                                                    <div class="form-group">
                                                        <label> Precio Total</label>
                                                        <input type="text" class="form-control" id="TOTAL_EQUIPO" name="TOTAL_EQUIPO">
                                                    </div>
                                                </div>


                                                <div class="col-4 mt-2">
                                                    <div class="form-group">
                                                        <label>Tipo </label>
                                                        <select class="form-select" id="TIPO_EQUIPO" name="TIPO_EQUIPO" required>
                                                            <option value="0" disabled selected>Seleccione una opción</option>
                                                            @foreach ($tipoinventario as $tipos)
                                                            <option value="{{ $tipos->DESCRIPCION_TIPO }}">{{ $tipos->DESCRIPCION_TIPO }}</option>
                                                            @endforeach


                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-12 mt-3">
                                                    <div class="form-group">
                                                        <label> Observación</label>
                                                        <textarea class="form-control" id="OBSERVACION_EQUIPO" name="OBSERVACION_EQUIPO" rows="5" required></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!--   Fin del tab información del producto -->


                        <!-- TAB 2: Entrada del producto -->
                        <div class="tab-pane fade" id="contenido-entrada" role="tabpanel">
                            <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
                                <h3 style="color: #ffffff; margin: 0;">&nbsp;Bitácora</h3>
                            </ol>

                            <div class="card-body">
                                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                                    <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablaentradainventario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="modal-footer mt-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarINVENTARIO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div id="modal_excel_equipo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post" name="formExcelEquipos" id="formExcelEquipos">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Carga de Equipos por medio de un Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! csrf_field() !!}
                        <div class="col-12">
                            <div class="form-group">
                                <label> Documento Excel *</label>
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput" id="input_file_excel_documento_equipo">
                                        <i class="fa fa-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-secondary btn-file">
                                        <span class="fileinput-new">Seleccione</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" accept=".xls,.xlsx" name="excelEquipos" id="excelEquipos" required>
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">Quitar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row mx-2" id="alertaVerificacion" style="display:none">
                        <p class="text-danger">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            Por favor, asegúrese de que el archivo Excel contenga la fecha en el formato válido:
                            <b>'2024-01-01'</b> (no se admiten fechas con texto) y también que el campo
                            <b>tipo</b> contenga únicamente uno de los siguientes valores, escritos <b>tal y como están</b>:
                            <u>Consumible</u>, <u>AF</u>, <u>ANF</u>, <u>Comercialización</u>,
                            <u>Material para curso</u>, <u>EPP</u>, <u>Vehículos</u>, <u>Donación</u>.
                        </p>
                    </div> -->

                    <div class="row mx-2" id="alertaVerificacion" style="display:none">
                        <p class="text-danger">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            Por favor, asegúrese de que el archivo Excel contenga la fecha en el formato válido:
                            <b>'2024-01-01'</b> (no se admiten fechas con texto) y también que el campo
                            <b>tipo</b> contenga únicamente uno de los siguientes valores, escritos <b>tal y como están</b>:
                            @foreach($tipoinventario as $tipo)
                            <u>{{ $tipo->DESCRIPCION_TIPO }}</u>@if(!$loop->last),@endif
                            @endforeach
                            .
                        </p>
                    </div>

                    <div class="row mt-3" id="divCargaEquipos" style="display: none;">

                        <div class="col-12 text-center">
                            <h2>Cargando equipos espere un momento...</h2>
                        </div>
                        <div class="col-12 text-center">
                            <i class='fa fa-spin fa-spinner fa-5x'></i>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>


                    <button type="submit" class="btn btn-success" id="botonCargarExcelEquipos">Guardar</button>


                </div>
            </form>
        </div>
    </div>
</div>


@endsection