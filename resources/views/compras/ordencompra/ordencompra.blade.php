@extends('principal.maestracompras')

@section('contenido')

<style>
    .modal-xl {
        max-width: 1200px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #000;
        padding: 4px 8px;
    }

    .table-sm td,
    .table-sm th {
        padding: 2px 4px;
    }

    .header-logo {
        max-height: 60px;
    }

    .signature-img {
        max-height: 80px;
    }

    .bg-light-gray {
        background-color: #f5f5f5;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Orden de compra</h3>
        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_asesores" data-bs-toggle="modal" data-bs-target="#purchaseOrderModal" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>




<div class="modal fade" id="purchaseOrderModal" tabindex="-1" aria-labelledby="purchaseOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseOrderModalLabel">Nueva Orden de Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="purchaseOrderForm">
                    <!-- Header -->
                    <table class="table table-bordered m-0">
                        <tr>
                            <td width="20%">
                            </td>
                            <td class="text-center">
                                <h4>Orden de compra</h4>
                            </td>
                            <td width="20%">
                               
                            </td>
                        </tr>
                    </table>

                    <!-- PO Number -->
                    <table class="table table-bordered m-0">
                        <tr>
                            <td width="75%" class="text-end">No. de orden de compra - PO</td>
                            <td width="25%" class="bg-light-gray">
                                <input type="text" class="form-control form-control-sm" id="poNumber" value="">
                            </td>
                        </tr>
                    </table>

                    <!-- Emisor -->
                    <table class="table table-bordered m-0">
                        <tr>
                            <td colspan="3" class="text-center bg-light-gray">Emisor de la orden de compra</td>
                        </tr>
                        <tr>
                            <td width="33%">
                                <input type="text" class="form-control form-control-sm" id="companyName" value="Results in Performance S.A. de C.V.">
                            </td>
                            <td width="33%">Ciudad / País</td>
                            <td width="33%">Fecha de emisión</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="rfc" value="RIP110622BV0">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="city" value="Villahermosa, México">
                            </td>
                            <td>
                                <input type="date" class="form-control form-control-sm" id="issueDate" value="2025-03-13">
                            </td>
                        </tr>
                        <tr>
                            <td>Contacto</td>
                            <td>Teléfono</td>
                            <td>No. de MR</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="contact" value="Virginia Licona Andrade">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="phone" value="993 147 2682">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="hrNumber" value="RESOT-25-004">
                            </td>
                        </tr>
                        <tr>
                            <td>Dirección</td>
                            <td>Celular</td>
                            <td rowspan="2">E-mail</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="address" value="Carmen Cadena de Buendía No. 123, Col. Nueva Villahermosa">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="mobile" value="938 1804173">
                            </td>
                          
                        </tr>
                    </table>

                    <!-- Proveedor -->
                    <table class="table table-bordered m-0">
                        <tr>
                            <td colspan="3" class="text-center bg-light-gray">Proveedor</td>
                        </tr>
                        <tr>
                            <td width="33%">
                                <input type="text" class="form-control form-control-sm" id="providerName" value="Idea Gráficos S.A. de C.V.">
                            </td>
                            <td width="33%">Ciudad / País</td>
                            <td width="33%">Fecha de entrega</td>
                        </tr>
                        <tr>
                            <td>Contacto</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="providerCity" value="Villahermosa, México">
                            </td>
                            <td>
                                <input type="date" class="form-control form-control-sm" id="deliveryDate" value="2025-03-11">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="providerContact" value="Alejandra Juárez Pacheco">
                            </td>
                            <td>Teléfono</td>
                            <td>Celular</td>
                        </tr>
                        <tr>
                            <td>Dirección</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="providerPhone" value="(993) 353 5385">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="providerMobile" value="(993) 339 5307">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" id="providerAddress" value="Juan Álvarez No. 505, Col. Centro C.P. 86000, Villahermosa, Tabasco">
                            </td>
                            <td colspan="2">E-mail</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="email" class="form-control form-control-sm" id="providerEmail" value="alejandra@grupoidea.com.mx">
                            </td>
                        </tr>
                    </table>

                    <!-- Productos -->
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="45%">Descripción</th>
                                <th width="10%">Cantidad</th>
                                <th width="15%">Precio Unitario</th>
                                <th width="15%">Importe</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productList">
                            <!-- Los productos se agregan dinámicamente -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <button type="button" class="btn btn-sm btn-success" id="addProductBtn">
                                        Agregar Producto
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Subtotal</td>
                                <td id="subtotal">$ 0.00</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">IVA</td>
                                <td id="iva">$ 0.00</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Total</td>
                                <td id="total">$ 0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Observaciones -->
                    <table class="table table-bordered m-0">
                        <tr>
                            <td colspan="2" class="text-center bg-light-gray">Observaciones o indicaciones especiales</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea class="form-control" id="observations" rows="4">De acuerdo con la nueva disposición fiscal del SAT para la facturación versión 4.0 considerar lo siguiente:
Forma de pago: "PPD" por definir (posteriormente debe emitirse el complemento de pago). "99%" transferencia electrónica de fondos.
Método de pago: "PUE" pago en parcialidades o diferido.
Uso de CFDI: G03 gastos en general
Debe incluir el número de la Orden de compra-PO y el número de Recepción del bien y/o servicio-RE en la factura

Recepción de facturas: Martes y jueves en horario de 9:00 - 15:00 horas</textarea>
                            </td>
                        </tr>
                    </table>

                    <!-- Firmas -->
                    <table class="table table-bordered m-0">
                        <tr>
                            <td width="50%" class="text-center">Solicitado por:</td>
                            <td width="50%" class="text-center">Aprobado por:</td>
                        </tr>
                        <tr>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <input type="text" class="form-control form-control-sm" id="requestedBy" value="Virginia Licona Andrade">
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control form-control-sm" id="approvedBy" value="Ricardo Castell Prata">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveOrderBtn">Guardar Orden</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm">
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="productDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productQuantity" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="productQuantity" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Precio Unitario</label>
                        <input type="number" class="form-control" id="productPrice" min="0" step="0.01" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmAddProductBtn">Agregar</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
        const productList = document.getElementById('productList');
        const addProductBtn = document.getElementById('addProductBtn');
        const confirmAddProductBtn = document.getElementById('confirmAddProductBtn');
        const saveOrderBtn = document.getElementById('saveOrderBtn');

        // Modales
        const purchaseOrderModal = new bootstrap.Modal(document.getElementById('purchaseOrderModal'));
        const addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));

        // Campos del formulario de producto
        const productDescription = document.getElementById('productDescription');
        const productQuantity = document.getElementById('productQuantity');
        const productPrice = document.getElementById('productPrice');

        // Elementos de totales
        const subtotalElement = document.getElementById('subtotal');
        const ivaElement = document.getElementById('iva');
        const totalElement = document.getElementById('total');

        // Datos de productos
        let products = [];

        // Precargar algunos productos de ejemplo
        const sampleProducts = [{
                description: 'Bolsas. Morral con jarreta color azul, modelo TXM22261, Valencia con terminado en 1 tinta, solo frente',
                quantity: 50,
                price: 42.50
            }
        ];

        // Agregar productos de muestra al cargar
        sampleProducts.forEach(product => {
            products.push(product);
        });

        // Renderizar productos iniciales
        renderProducts();
        calculateTotals();

        // Event Listeners
        addProductBtn.addEventListener('click', function() {
            // Limpiar formulario
            productDescription.value = '';
            productQuantity.value = 1;
            productPrice.value = '';

            // Mostrar modal
            addProductModal.show();
        });

        confirmAddProductBtn.addEventListener('click', function() {
            // Validar formulario
            if (!productDescription.value || !productQuantity.value || !productPrice.value) {
                alert('Todos los campos son obligatorios');
                return;
            }

            // Crear nuevo producto
            const newProduct = {
                description: productDescription.value,
                quantity: parseInt(productQuantity.value),
                price: parseFloat(productPrice.value)
            };

            // Agregar a la lista
            products.push(newProduct);

            // Actualizar vista
            renderProducts();
            calculateTotals();

            // Cerrar modal
            addProductModal.hide();
        });

        saveOrderBtn.addEventListener('click', function() {
            alert('Orden de compra guardada exitosamente');
            purchaseOrderModal.hide();
        });

        // Función para renderizar productos
        function renderProducts() {
            productList.innerHTML = '';

            products.forEach((product, index) => {
                const row = document.createElement('tr');

                // Calcular importe
                const amount = product.quantity * product.price;

                row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${product.description}</td>
                        <td class="text-center">${product.quantity}</td>
                        <td class="text-end">$ ${product.price.toFixed(2)}</td>
                        <td class="text-end">$ ${amount.toFixed(2)}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger deleteBtn" data-index="${index}">
                                Eliminar
                            </button>
                        </td>
                    `;

                productList.appendChild(row);
            });

            // Agregar event listeners a botones de eliminar
            document.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    products.splice(index, 1);
                    renderProducts();
                    calculateTotals();
                });
            });
        }

        // Función para calcular totales
        function calculateTotals() {
            // Calcular subtotal
            const subtotal = products.reduce((sum, product) => {
                return sum + (product.quantity * product.price);
            }, 0);

            // Calcular IVA (16%)
            const iva = subtotal * 0.16;

            // Calcular total
            const total = subtotal + iva;

            // Actualizar elementos en el DOM
            subtotalElement.textContent = `$ ${subtotal.toFixed(2)}`;
            ivaElement.textContent = `$ ${iva.toFixed(2)}`;
            totalElement.textContent = `$ ${total.toFixed(2)}`;
        }

        // Mostrar modal de orden de compra al cargar la página (descomentar si se desea)
        // purchaseOrderModal.show();
    });
</script>


@endsection