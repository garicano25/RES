@extends('principal.maestracompras')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Matriz comparativa de cotizaciones</h3>
        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_asesores" data-bs-toggle="modal" data-bs-target="#proveedoresModal" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>


<div class="modal fade" id="proveedoresModal" tabindex="-1" aria-labelledby="proveedoresModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proveedoresModalLabel">Comparación de Proveedores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <button id="addProveedorBtn" class="btn btn-success">+ Agregar Proveedor</button>
                    <div>
                        <strong>No. de MR:</strong> <span id="mrNumber">RES-MR24-047</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="comparacionTable">
                        <thead class="sticky-header">
                            <tr>
                                <th>Descripción del bien y/o servicio</th>
                                <th>Cantidad</th>
                                <th colspan="2" id="proveedor1Header">
                                    <select class="form-select proveedor-select">
                                        <option value="" disabled selected>Seleccionar proveedor</option>
                                        <option value="1">Nuclear Fire</option>
                                        <option value="2">RICAR Seguridad Industrial</option>
                                        <option value="3">SCIndustrial</option>
                                        <option value="4">Seguridad Industrial y Ferretería LAMAR</option>
                                        <option value="5">Extintores del Centro</option>
                                        <option value="6">Grupo Sica</option>
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th>P. Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Recarga y Mtto Extintores CO2, 4.5 kg</td>
                                <td>10</td>
                                <td><input type="number" class="form-control precio-unitario" data-row="0" data-proveedor="0"></td>
                                <td class="total-cell">$0.00</td>
                            </tr>
                            <tr>
                                <td>Recarga y Mtto Extintores CO2, 6 kg</td>
                                <td>2</td>
                                <td><input type="number" class="form-control precio-unitario" data-row="1" data-proveedor="0"></td>
                                <td class="total-cell">$0.00</td>
                            </tr>
                            <tr>
                                <td>Recarga y Mtto Extintores PQS, 4.5 kg</td>
                                <td>1</td>
                                <td><input type="number" class="form-control precio-unitario" data-row="2" data-proveedor="0"></td>
                                <td class="total-cell">$0.00</td>
                            </tr>
                            <tr>
                                <td colspan="2">Observaciones:</td>
                                <td colspan="2">
                                    <textarea class="form-control observaciones" data-proveedor="0"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Subtotal:</td>
                                <td colspan="2" class="subtotal-cell">$0.00</td>
                            </tr>
                            <tr>
                                <td colspan="2">IVA:</td>
                                <td colspan="2" class="iva-cell">$0.00</td>
                            </tr>
                            <tr>
                                <td colspan="2">Total:</td>
                                <td colspan="2" class="total-general-cell">$0.00</td>
                            </tr>
                            <tr>
                                <td colspan="2">Fecha de cotización:</td>
                                <td colspan="2"><input type="date" class="form-control fecha-cotizacion" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Vigencia de cotización (días):</td>
                                <td colspan="2"><input type="number" class="form-control vigencia-cotizacion" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Tiempo de entrega:</td>
                                <td colspan="2"><input type="text" class="form-control tiempo-entrega" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Condiciones de pago:</td>
                                <td colspan="2"><input type="text" class="form-control condiciones-pago" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Condiciones de garantía:</td>
                                <td colspan="2"><input type="text" class="form-control condiciones-garantia" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Servicio postventa:</td>
                                <td colspan="2"><input type="text" class="form-control servicio-postventa" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Beneficios adicionales por el proveedor:</td>
                                <td colspan="2"><input type="text" class="form-control beneficios-adicionales" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Especificaciones adicionales (no técnicas) que fueron requeridas por el bien y/o servicio o adquisición:</td>
                                <td colspan="2"><input type="text" class="form-control especificaciones-adicionales" data-proveedor="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Certificaciones de calidad (opcional):</td>
                                <td colspan="2"><input type="text" class="form-control certificaciones-calidad" data-proveedor="0"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h5>Criterios de selección:</h5>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioPrecio">
                                <label class="form-check-label" for="criterioPrecio">Precio</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioTiempoEntrega">
                                <label class="form-check-label" for="criterioTiempoEntrega">Tiempo de entrega</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioCondicionesPago">
                                <label class="form-check-label" for="criterioCondicionesPago">Condiciones de pago</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioCalidad">
                                <label class="form-check-label" for="criterioCalidad">Calidad</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioServicioPostventa">
                                <label class="form-check-label" for="criterioServicioPostventa">Servicio postventa</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioCondicionesGarantia">
                                <label class="form-check-label" for="criterioCondicionesGarantia">Condiciones de garantía</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioBeneficiosAdicionales">
                                <label class="form-check-label" for="criterioBeneficiosAdicionales">Beneficios adicionales</label>
                            </div>
                            <div class="input-group mt-2">
                                <span class="input-group-text">¿Cuál?</span>
                                <input type="text" class="form-control" id="beneficiosAdicionalesCual">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="criterioOtros">
                                <label class="form-check-label" for="criterioOtros">Otros</label>
                            </div>
                            <div class="input-group mt-2">
                                <span class="input-group-text">¿Cuál?</span>
                                <input type="text" class="form-control" id="otrosCual">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="form-group">
                        <label for="proveedorSeleccionado" class="form-label">Nombre del proveedor seleccionado:</label>
                        <input type="text" class="form-control" id="proveedorSeleccionado">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        const comparacionTable = document.getElementById('comparacionTable');
        const addProveedorBtn = document.getElementById('addProveedorBtn');
        let proveedorCount = 1;

        // Inicializar la tabla
        initInputEvents();

        // Evento para agregar nuevo proveedor
        addProveedorBtn.addEventListener('click', function() {
            addProveedor();
        });

        // Función para agregar un nuevo proveedor
        function addProveedor() {
            proveedorCount++;

            // Agregar columnas en el encabezado
            const headerRow1 = comparacionTable.querySelector('thead tr:first-child');
            const headerCell = document.createElement('th');
            headerCell.setAttribute('colspan', '2');
            headerCell.setAttribute('id', `proveedor${proveedorCount}Header`);
            headerCell.textContent = `Proveedor No. ${proveedorCount}`;
            headerRow1.appendChild(headerCell);

            // Agregar columnas en el segundo encabezado
            const headerRow2 = comparacionTable.querySelector('thead tr:nth-child(2)');
            const unitPriceHeader = document.createElement('th');
            unitPriceHeader.textContent = 'P. Unitario';
            headerRow2.appendChild(unitPriceHeader);

            const totalPriceHeader = document.createElement('th');
            totalPriceHeader.textContent = 'Total';
            headerRow2.appendChild(totalPriceHeader);

            // Agregar celdas en todas las filas de la tabla
            const tbody = comparacionTable.querySelector('tbody');
            const rows = tbody.querySelectorAll('tr');

            rows.forEach((row, rowIndex) => {
                if (rowIndex <= 2) {
                    // Filas de productos
                    const unitPriceCell = document.createElement('td');
                    const unitPriceInput = document.createElement('input');
                    unitPriceInput.type = 'number';
                    unitPriceInput.className = 'form-control precio-unitario';
                    unitPriceInput.setAttribute('data-row', rowIndex);
                    unitPriceInput.setAttribute('data-proveedor', proveedorCount - 1);
                    unitPriceInput.addEventListener('input', updateTotals);
                    unitPriceCell.appendChild(unitPriceInput);
                    row.appendChild(unitPriceCell);

                    const totalCell = document.createElement('td');
                    totalCell.className = 'total-cell';
                    totalCell.textContent = '$0.00';
                    row.appendChild(totalCell);
                } else if (rowIndex === 3) {
                    // Fila de observaciones
                    const obsCell = document.createElement('td');
                    obsCell.setAttribute('colspan', '2');
                    const obsTextarea = document.createElement('textarea');
                    obsTextarea.className = 'form-control observaciones';
                    obsTextarea.setAttribute('data-proveedor', proveedorCount - 1);
                    obsCell.appendChild(obsTextarea);
                    row.appendChild(obsCell);
                } else if (rowIndex === 4 || rowIndex === 5 || rowIndex === 6) {
                    // Filas de subtotal, IVA y total
                    const totalCell = document.createElement('td');
                    totalCell.setAttribute('colspan', '2');
                    if (rowIndex === 4) totalCell.className = 'subtotal-cell';
                    if (rowIndex === 5) totalCell.className = 'iva-cell';
                    if (rowIndex === 6) totalCell.className = 'total-general-cell';
                    totalCell.textContent = '$0.00';
                    row.appendChild(totalCell);
                } else {
                    // Resto de filas
                    const inputCell = document.createElement('td');
                    inputCell.setAttribute('colspan', '2');
                    const input = document.createElement('input');
                    input.type = rowIndex === 7 ? 'date' : 'text';
                    if (rowIndex === 8) input.type = 'number';

                    // Asignar la clase correcta según la fila
                    if (rowIndex === 7) input.className = 'form-control fecha-cotizacion';
                    else if (rowIndex === 8) input.className = 'form-control vigencia-cotizacion';
                    else if (rowIndex === 9) input.className = 'form-control tiempo-entrega';
                    else if (rowIndex === 10) input.className = 'form-control condiciones-pago';
                    else if (rowIndex === 11) input.className = 'form-control condiciones-garantia';
                    else if (rowIndex === 12) input.className = 'form-control servicio-postventa';
                    else if (rowIndex === 13) input.className = 'form-control beneficios-adicionales';
                    else if (rowIndex === 14) input.className = 'form-control especificaciones-adicionales';
                    else if (rowIndex === 15) input.className = 'form-control certificaciones-calidad';

                    input.setAttribute('data-proveedor', proveedorCount - 1);
                    inputCell.appendChild(input);
                    row.appendChild(inputCell);
                }
            });

            // Inicializar los eventos de los nuevos inputs
            initInputEvents();
        }

        // Función para inicializar los eventos de los inputs
        function initInputEvents() {
            const precioInputs = document.querySelectorAll('.precio-unitario');
            precioInputs.forEach(input => {
                input.addEventListener('input', updateTotals);
            });
        }

        // Función para actualizar totales
        function updateTotals(event) {
            const input = event.target;
            const row = parseInt(input.getAttribute('data-row'));
            const proveedor = parseInt(input.getAttribute('data-proveedor'));

            // Obtener cantidad y precio
            const cantidad = parseInt(comparacionTable.querySelector(`tbody tr:nth-child(${row + 1}) td:nth-child(2)`).textContent);
            const precioUnitario = parseFloat(input.value) || 0;

            // Calcular total
            const total = cantidad * precioUnitario;

            // Actualizar celda de total
            const colBase = 3; // Columnas iniciales (descripción y cantidad)
            const colPorProveedor = 2; // Columnas por proveedor (P.Unitario y Total)
            const totalCol = colBase + (proveedor * colPorProveedor) + 1;

            const totalCell = comparacionTable.querySelector(`tbody tr:nth-child(${row + 1}) td:nth-child(${totalCol})`);
            totalCell.textContent = formatCurrency(total);

            // Actualizar subtotal, IVA y total general del proveedor
            updateProveedorTotals(proveedor);
        }

        // Función para actualizar subtotal, IVA y total general del proveedor
        function updateProveedorTotals(proveedor) {
            // Calcular subtotal
            let subtotal = 0;
            const productos = comparacionTable.querySelectorAll('.precio-unitario[data-proveedor="' + proveedor + '"]');

            productos.forEach((input, index) => {
                const row = parseInt(input.getAttribute('data-row'));
                const cantidad = parseInt(comparacionTable.querySelector(`tbody tr:nth-child(${row + 1}) td:nth-child(2)`).textContent);
                const precioUnitario = parseFloat(input.value) || 0;
                subtotal += cantidad * precioUnitario;
            });

            // Calcular IVA (16%)
            const iva = subtotal * 0.16;

            // Calcular total
            const total = subtotal + iva;

            // Actualizar celdas
            const colBase = 3; // Columnas iniciales (descripción y cantidad)
            const colPorProveedor = 2; // Columnas por proveedor (P.Unitario y Total)
            const totalCol = colBase + (proveedor * colPorProveedor);

            const subtotalCell = comparacionTable.querySelector(`tbody tr:nth-child(5) td:nth-child(${totalCol})`);
            const ivaCell = comparacionTable.querySelector(`tbody tr:nth-child(6) td:nth-child(${totalCol})`);
            const totalCell = comparacionTable.querySelector(`tbody tr:nth-child(7) td:nth-child(${totalCol})`);

            subtotalCell.textContent = formatCurrency(subtotal);
            ivaCell.textContent = formatCurrency(iva);
            totalCell.textContent = formatCurrency(total);
        }

        // Función para formatear moneda
        function formatCurrency(value) {
            return '$' + value.toFixed(2);
        }
    });
</script>

@endsection