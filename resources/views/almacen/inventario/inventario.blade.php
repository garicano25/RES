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
</style>


<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"> <i class="bi bi-card-list" style="margin-right: 5px;"></i> Inventario
        </h3>

        <button type="button" class="btn btn-secondary waves-effect waves-light " data-toggle="tooltip" title="Cargar equipos por medio de un archivo Excel" id="boton_cargarExcelEquipos" style="margin-left: 77%;">
            Importar <i class="bi bi-file-earmark-excel-fill"></i>
        </button>

        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_EQUIPO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablainventario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>






<div id="Modal_inventario" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 86%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Equipo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">


                        </style>
                        <form method="post" enctype="multipart/form-data" id="formularioINVENTARIO" style="background-color: #ffffff;">
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

                                        <div class="col-8 ">
                                            <div class="form-group">
                                                <label> Descripción del equipo*</label>
                                                <input type="text" class="form-control" id="DESCRIPCION_EQUIPO" name="DESCRIPCION_EQUIPO" required>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label> Marca </label>
                                                <input type="text" class="form-control" id="MARCA_EQUIPO" name="MARCA_EQUIPO">
                                            </div>
                                        </div>
                                        <div class="col-4 mt-2">
                                            <div class="form-group">
                                                <label> Modelo </label>
                                                <input type="text" class="form-control" id="MODELO_EQUIPO" name="MODELO_EQUIPO">
                                            </div>
                                        </div>
                                        <div class="col-4 mt-2">
                                            <div class="form-group">
                                                <label> Serie </label>
                                                <input type="text" class="form-control" id="SERIE_EQUIPO" name="SERIE_EQUIPO">
                                            </div>
                                        </div>
                                        <div class="col-4 mt-2">
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
                                                    <option disabled selected>Seleccione una opción</option>
                                                    <option value="Consumible">Consumible</option>
                                                    <option value="AF">AF</option>
                                                    <option value="ANF">ANF</option>
                                                    <option value="Comercialización">Comercialización</option>
                                                    <option value="Material para curso">Material para curso</option>
                                                    <option value="EPP">EPP</option>
                                                    <option value="Vehículos">Vehículos</option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div class="modal-footer mt-5">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" id="guardarINVENTARIO">Guardar</button>
            </div>
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
                    <div class="row mx-2" id="alertaVerificacion" style="display:none">
                        <p class="text-danger">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            Por favor, asegúrese de que el archivo Excel contenga la fecha en el formato válido:
                            <b>'2024-01-01'</b> (no se admiten fechas con texto) y también que el campo
                            <b>tipo</b> contenga únicamente uno de los siguientes valores, escritos <b>tal y como están</b>:
                            <u>Consumible</u>, <u>AF</u>, <u>ANF</u>, <u>Comercialización</u>,
                            <u>Material para curso</u>, <u>EPP</u>, <u>Vehículos</u>.
                        </p>
                    </div>

                    <div class="row mt-3" id="divCargaEquipos" style="display: none;">

                        <div class="col-12 text-center">
                            <h2>Cargando equipo espere un momento...</h2>
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