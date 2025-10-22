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
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">

        <h3 class="mb-0 text-white">
            <i class="bi bi-list-task"></i> Lista de activo fijo
        </h3>
    </ol>

    <div class="card-body">
        <table id="Tablalistadeaf" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
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
                                                <div class="col-2 mt-2">
                                                    <div class="form-group">
                                                        <label> Cantidad </label>
                                                        <input type="Number" step="any" class="form-control" id="CANTIDAD_EQUIPO" name="CANTIDAD_EQUIPO">
                                                    </div>
                                                </div>


                                                <div class="col-2 mt-2">
                                                    <div class="form-group">
                                                        <label> U.M. </label>
                                                        <input type="text" step="any" class="form-control" id="UNIDAD_MEDIDA" name="UNIDAD_MEDIDA">
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

                                                <div class="col-12 mt-2" id="DESPUES_2024" style="display: block;">
                                                    <label class="form-label">Proveedor</label>



                                                    <select class="form-select text-center" id="PROVEEDOR_EQUIPO" name="PROVEEDOR_EQUIPO">
                                                        <option value="">Seleccionar proveedor</option>
                                                        <optgroup label="Proveedor oficial">
                                                            @foreach ($proveedoresOficiales as $proveedor)
                                                            <option value="{{ $proveedor->RFC_ALTA }}">
                                                                {{ $proveedor->RAZON_SOCIAL_ALTA }} ({{ $proveedor->RFC_ALTA }})
                                                            </option>
                                                            @endforeach
                                                        </optgroup>
                                                        <optgroup label="Proveedores temporales">
                                                            @foreach ($proveedoresTemporales as $proveedor)
                                                            <option value="{{ $proveedor->RAZON_PROVEEDORTEMP }}">
                                                                {{ $proveedor->RAZON_PROVEEDORTEMP }} ({{ $proveedor->NOMBRE_PROVEEDORTEMP }})
                                                            </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>


                                                <div class="col-12 mt-2" id="ANTES_2024" style="display: none;">
                                                    <label class="form-label">Proveedor</label>
                                                    <input type="text" class="form-control" id="PROVEEDOR_ANTESDEL2024">
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




@endsection