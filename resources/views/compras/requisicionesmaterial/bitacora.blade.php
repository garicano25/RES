@extends('principal.maestracompras')

@section('contenido')

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Bitácora de consecutivos MR</h3>
    </ol>
</div>

<!-- Contenedor con scroll horizontal si la tabla es muy ancha -->
<div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-hover bg-white table-bordered text-center w-100 TableCustom" style="min-width: 2000px;">
        <thead class="thead-dark">
            <tr>
                <th style="width: 150px; white-space: nowrap;">Requisición No.</th>
                <th style="width: 180px; white-space: nowrap;">Fecha de Solicitud</th>
                <th style="width: 200px; white-space: nowrap;">Solicitante</th>
                <th style="width: 220px; white-space: nowrap;">Área Solicitante</th>
                <th style="width: 180px; white-space: nowrap;">Fecha de Vo. Bo.</th>
                <th style="width: 180px; white-space: nowrap;">Fecha Aprobación</th>
                <th style="width: 200px; white-space: nowrap;">Aprobación</th>
                <th style="width: 220px; white-space: nowrap;">Línea de Negocio</th>
                <th style="width: 180px; white-space: nowrap;">Prioridad</th>
                <th style="width: 250px; white-space: nowrap;">Concepto</th>
                <th style="width: 180px; white-space: nowrap;">Estatus</th>
                <th style="width: 250px; white-space: nowrap;">Comentario</th>
                <th style="width: 180px; white-space: nowrap;">Requiere PO</th>
                <th style="width: 180px; white-space: nowrap;">Fecha de Adquisición</th>
                <th style="width: 220px; white-space: nowrap;">Proveedor</th>
                <th style="width: 220px; white-space: nowrap;">Forma de Pago</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" class="form-control" name="requisicion_no" style="width: 100%;"></td>
                <td><input type="date" class="form-control" name="fecha_solicitud" style="width: 100%;"></td>
                <td><input type="text" class="form-control" name="solicitante" style="width: 100%;"></td>
                <td><input type="text" class="form-control" name="area_solicitante" style="width: 100%;"></td>
                <td><input type="date" class="form-control" name="fecha_vo_bo" style="width: 100%;"></td>
                <td><input type="date" class="form-control" name="fecha_aprobacion" style="width: 100%;"></td>
                <td><input type="text" class="form-control" name="aprobacion" style="width: 100%;"></td>
                <td>
                    <select class="form-control" name="linea_negocio" style="width: 100%;">
                        <option value="" selected disabled>Seleccione</option>
                        <option value="Calidad">Calidad</option>
                        <option value="Salud">Salud</option>
                        <option value="Seguridad">Seguridad</option>
                        <option value="Trabajo">Trabajo</option>
                    </select>
                </td>
                <td>
                    <select class="form-control" name="prioridad" style="width: 100%;">
                        <option value="" selected disabled>Seleccione</option>
                        <option value="Alta">Alta (1-15 días)</option>
                        <option value="Media">Media (16-30 días)</option>
                        <option value="Baja">Baja (31-60 días)</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="concepto" style="width: 100%;"></td>
                <td>
                    <select class="form-control" name="estatus" style="width: 100%;">
                        <option value="" selected disabled>Seleccione</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Cancelada">Cancelada</option>
                        <option value="Finalizada">Finalizada</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="comentario" style="width: 100%;"></td>
                <td>
                    <select class="form-control" name="requiere_po" style="width: 100%;">
                        <option value="" selected disabled>Seleccione</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="fecha_adquisicion" style="width: 100%;"></td>
                <td><input type="text" class="form-control" name="proveedor" style="width: 100%;"></td>
                <td><input type="text" class="form-control" name="forma_pago" style="width: 100%;"></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection